<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['ReservationID', 'CustomerID', 'DepArrivalAirportCodeartureTime','ReservationDate'].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.ReservationID]"
                        v-model:value="editableData[record.ReservationID][column.dataIndex]" style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.ReservationID]">
                        <a-typography-link @click="save(record.ReservationID)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.ReservationID)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.ReservationID)">Edit</a>
                    </span>
                </div>
            </template>
        </template>
    </a-table>
</template>
<script>
import { cloneDeep } from 'lodash-es';
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

const columns = [
    {
        title: 'ReservationID',
        dataIndex: 'ReservationID',
    },
    {
        title: 'CustomerID',
        dataIndex: 'CustomerID',
    },
    {
        title: 'FlightID',
        dataIndex: 'FlightID',
    },
    {
        title: 'ReservationDate',
        dataIndex: 'ReservationDate',
    },
    {
        title: 'operation',
        dataIndex: 'operation',
    },
];

export default defineComponent({
    setup() {
        const dataSource = ref([]);
        const editableData = reactive({});
        const edit = (ReservationID) => {
            editableData[ReservationID] = cloneDeep(
                dataSource.value.filter((item) => ReservationID === item.ReservationID)[0]
            );
        };
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showReservation.php').then((response) => {
                // console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };
        const save = (ReservationID) => {
            const editedData = editableData[ReservationID];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response);
                fetchData();
            });
            delete editableData[ReservationID];
        };
        const cancel = (ReservationID) => {
            delete editableData[ReservationID];
        };

        axios.get('http://localhost/databigvue/php/showReservation.php').then((response) => {
            // console.log(response.data);
            dataSource.value = response.data[0].data;
        });

        return {
            dataSource,
            columns,
            editingKey: '',
            editableData,
            edit,
            save,
            cancel,
        };
    },
});
</script>
<style scoped>
.editable-row-operations a {
    margin-right: 8px;
}
</style>
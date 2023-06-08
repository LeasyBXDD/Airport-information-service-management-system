<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['SeatID', 'SeatNumber', 'AircraftID'].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.SeatID]" v-model:value="editableData[record.SeatID][column.dataIndex]"
                        style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.SeatID]">
                        <a-typography-link @click="save(record.SeatID)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.SeatID)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.SeatID)">Edit</a>
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
        title: 'SeatID',
        dataIndex: 'SeatID',
    },
    {
        title: 'SeatNumber',
        dataIndex: 'SeatNumber',
    },
    {
        title: 'AircraftID',
        dataIndex: 'AircraftID',
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
        const edit = (SeatID) => {
            editableData[SeatID] = cloneDeep(
                dataSource.value.filter((item) => SeatID === item.SeatID)[0]
            );
        };
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showSeat.php').then((response) => {
                // console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };
        const save = (SeatID) => {
            const editedData = editableData[SeatID];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData,{
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response);
                fetchData();
            });
            delete editableData[SeatID];
        };
        const cancel = (SeatID) => {
            delete editableData[SeatID];
        };

        axios.get('http://localhost/databigvue/php/showSeat.php').then((response) => {
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
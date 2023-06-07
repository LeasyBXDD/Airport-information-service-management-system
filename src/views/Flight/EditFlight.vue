<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['FlightID', 'FlightNumber', 'DepArrivalAirportCodeartureTime','ArrivalTime','FlightStatus','AircraftID','DepartureAirportCode',''].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.FlightID]"
                        v-model:value="editableData[record.FlightID][column.dataIndex]" style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.FlightID]">
                        <a-typography-link @click="save(record.FlightID)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.FlightID)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.FlightID)">Edit</a>
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
        title: 'FlightID',
        dataIndex: 'FlightID',
    },
    {
        title: 'FlightNumber',
        dataIndex: 'FlightNumber',
    },
    {
        title: 'DepartureTime',
        dataIndex: 'DepartureTime',
    },
    {
        title: 'ArrivalTime',
        dataIndex: 'ArrivalTime',
    },
    {
        title: 'FlightStatus',
        dataIndex: 'FlightStatus',
    },
    {
        title: 'AircraftID',
        dataIndex: 'AircraftID',
    },
    {
        title: 'DepartureAirportCode',
        dataIndex: 'DepartureAirportCode',
    },
    {
        title: 'ArrivalAirportCode',
        dataIndex: 'ArrivalAirportCode',
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
        const edit = (FlightID) => {
            editableData[FlightID] = cloneDeep(
                dataSource.value.filter((item) => FlightID === item.FlightID)[0]
            );
        };
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showFlight.php').then((response) => {
                // console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };
        const save = (FlightID) => {
            const editedData = editableData[FlightID];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response);
                fetchData();
            });
            delete editableData[FlightID];
        };
        const cancel = (FlightID) => {
            delete editableData[FlightID];
        };

        axios.get('http://localhost/databigvue/php/showFlight.php').then((response) => {
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
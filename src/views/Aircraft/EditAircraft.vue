<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['AircraftID', 'AircraftType', 'NumberOfSeats'].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.AircraftID]" v-model:value="editableData[record.AircraftID][column.dataIndex]"
                        style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.AircraftID]">
                        <a-typography-link @click="save(record.AircraftID)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.AircraftID)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.AircraftID)">Edit</a>
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
        title: 'AircraftID',
        dataIndex: 'AircraftID',
    },
    {
        title: 'AircraftType',
        dataIndex: 'AircraftType',
    },
    {
        title: 'NumberOfSeats',
        dataIndex: 'NumberOfSeats',
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
        const edit = (AircraftID) => {
            editableData[AircraftID] = cloneDeep(
                dataSource.value.filter((item) => AircraftID === item.AircraftID)[0]
            );
        };
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showAircraft.php').then((response) => {
                // console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };
        const save = (AircraftID) => {
            const editedData = editableData[AircraftID];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData,{
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response);
                fetchData();
            });
            delete editableData[AircraftID];
        };
        const cancel = (AircraftID) => {
            delete editableData[AircraftID];
        };

        axios.get('http://localhost/databigvue/php/showAircraft.php').then((response) => {
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
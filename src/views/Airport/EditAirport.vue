<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['AirportCode', 'AirportName'].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.AirportCode]"
                        v-model:value="editableData[record.AirportCode][column.dataIndex]" style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.AirportCode]">
                        <a-typography-link @click="save(record.AirportCode)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.AirportCode)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.AirportCode)">Edit</a>
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
        title: 'AirportCode',
        dataIndex: 'AirportCode',
    },
    {
        title: 'AirportName',
        dataIndex: 'AirportName',
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
        const edit = (AirportCode) => {
            editableData[AirportCode] = cloneDeep(
                dataSource.value.filter((item) => AirportCode === item.AirportCode)[0]
            );
        };
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showAirport.php').then((response) => {
                // console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };
        const save = (AirportCode) => {
            const editedData = editableData[AirportCode];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response);
                fetchData();
            });
            delete editableData[AirportCode];
        };
        const cancel = (AirportCode) => {
            delete editableData[AirportCode];
        };

        axios.get('http://localhost/databigvue/php/showAirport.php').then((response) => {
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
<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['CustomerID', 'Name', 'ContactInfo'].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.CustomerID]" v-model:value="editableData[record.CustomerID][column.dataIndex]"
                        style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.CustomerID]">
                        <a-typography-link @click="save(record.CustomerID)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.CustomerID)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.CustomerID)">Edit</a>
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
        title: 'CustomerID',
        dataIndex: 'CustomerID',
        width: '25%',
    },
    {
        title: 'Name',
        dataIndex: 'Name',
        width: '15%',
    },
    {
        title: 'ContactInfo',
        dataIndex: 'ContactInfo',
        width: '40%',
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
        const edit = (CustomerID) => {
            editableData[CustomerID] = cloneDeep(
                dataSource.value.filter((item) => CustomerID === item.CustomerID)[0]
            );
        };
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
                // console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };
        const save = (CustomerID) => {
            const editedData = editableData[CustomerID];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData,{
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response);
                fetchData();
            });
            delete editableData[CustomerID];
        };
        const cancel = (CustomerID) => {
            delete editableData[CustomerID];
        };

        axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
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
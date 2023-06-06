<template>
    <a-table :columns="columns" :data-source="dataSource" bordered>
        <template #bodyCell="{ column, text, record }">
            <template v-if="['name', 'age', 'address'].includes(column.dataIndex)">
                <div>
                    <a-input v-if="editableData[record.key]" v-model:value="editableData[record.key][column.dataIndex]"
                        style="margin: -5px 0" />
                    <template v-else>
                        {{ text }}
                    </template>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <div class="editable-row-operations">
                    <span v-if="editableData[record.key]">
                        <a-typography-link @click="save(record.key)">Save</a-typography-link>
                        <a-popconfirm title="Sure to cancel?" @confirm="cancel(record.key)">
                            <a>Cancel</a>
                        </a-popconfirm>
                    </span>
                    <span v-else>
                        <a @click="edit(record.key)">Edit</a>
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
        const edit = (key) => {
            editableData[key] = cloneDeep(
                dataSource.value.filter((item) => key === item.key)[0]
            );
        };
        const save = (key) => {
            const editedData = editableData[key];
            axios.post('http://localhost/databigvue/php/edituser.php', editedData).then((response) => {
                console.log(response.data);
                fetchData();
            });
            delete editableData[key];
        };
        const cancel = (key) => {
            delete editableData[key];
        };

        axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
            console.log(response.data);
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
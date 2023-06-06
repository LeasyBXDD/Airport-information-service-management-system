<template>
    <a-table bordered :data-source="dataSource" :columns="columns">
        <template #bodyCell="{ column, text, record }">
            <template v-if="column.dataIndex === 'CustomerID'">
                <div class="editable-cell">
                    <div v-if="editableData[record.CustomerID]" class="editable-cell-input-wrapper">
                        <a-input v-model:value="editableData[record.CustomerID].name" @pressEnter="save(record.CustomerID)" />
                        <check-outlined class="editable-cell-icon-check" @click="save(record.CustomerID)" />
                    </div>
                    <div v-else class="editable-cell-text-wrapper">
                        {{ text || ' ' }}
                        <edit-outlined class="editable-cell-icon" @click="edit(record.CustomerID)" />
                    </div>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <a-popconfirm v-if="dataSource.length" title="Sure to delete?" @confirm="onDelete(record.CustomerID)">
                    <a>Delete</a>
                </a-popconfirm>
            </template>
        </template>
    </a-table>
</template>
<script>
import { computed, defineComponent, reactive, ref } from 'vue';
import { CheckOutlined, EditOutlined } from '@ant-design/icons-vue';
import { cloneDeep } from 'lodash-es';
import axios from 'axios';

export default defineComponent({
    components: {
        CheckOutlined,
        EditOutlined,
    },
    setup() {

        const columns = [{
            title: 'CustomerID',
            dataIndex: 'CustomerID',
            width: '30%',
        }, {
            title: 'Name',
            dataIndex: 'Name',
        }, {
            title: 'ContactInfo',
            dataIndex: 'ContactInfo',
        }, {
            title: 'operation',
            dataIndex: 'operation',
        }];
        const dataSource = ref([]);
        const count = computed(() => dataSource.value.length + 1);
        const editableData = reactive({});
        const edit = CustomerID => {
            editableData[CustomerID] = cloneDeep(dataSource.value.filter(item => CustomerID === item.key)[0]);
        };
        const save = CustomerID => {
            Object.assign(dataSource.value.filter(item => CustomerID === item.CustomerID)[0], editableData[CustomerID]);
            delete editableData[CustomerID];
        };
        // const onDelete = key => {
        //     dataSource.value = dataSource.value.filter(item => item.key !== key);
        // };
        const handleAdd = () => {
            const newData = {
                CustomerID: `${count.value}`,
                Name: `Edward King ${count.value}`,
                ContactInfo: `London, Park Lane no. ${count.value}`,
            };
            dataSource.value.push(newData);
        };

        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
                console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };

        axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
            console.log(response.data);
            dataSource.value = response.data[0].data;
        });

        const onDelete = CustomerID => {
            console.log(CustomerID);
            dataSource.value = dataSource.value.filter(item => item.CustomerID !== CustomerID);
            axios.post('http://localhost/databigvue/php/deluser.php', {
                CustomerID
            },{
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then((response) => {
                console.log(response.data);
                fetchData();
            });
        };

        return {
            fetchData,
            columns,
            onDelete,
            handleAdd,
            dataSource,
            editableData,
            count,
            edit,
            save,
        };
    },
});
</script>
<style lang="less">
.editable-cell {
    position: relative;

    .editable-cell-input-wrapper,
    .editable-cell-text-wrapper {
        padding-right: 24px;
    }

    .editable-cell-text-wrapper {
        padding: 5px 24px 5px 5px;
    }

    .editable-cell-icon,
    .editable-cell-icon-check {
        position: absolute;
        right: 0;
        width: 20px;
        cursor: pointer;
    }

    .editable-cell-icon {
        margin-top: 4px;
        display: none;
    }

    .editable-cell-icon-check {
        line-height: 28px;
    }

    .editable-cell-icon:hover,
    .editable-cell-icon-check:hover {
        color: #108ee9;
    }

    .editable-add-btn {
        margin-bottom: 8px;
    }
}

.editable-cell:hover .editable-cell-icon {
    display: inline-block;
}
</style>
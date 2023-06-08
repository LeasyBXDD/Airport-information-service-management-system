<template>
    <a-table bordered :data-source="dataSource" :columns="columns">
        <template #bodyCell="{ column, text, record }">
            <template v-if="column.dataIndex === 'SeatID'">
                <div class="editable-cell">
                    <div v-if="editableData[record.SeatID]" class="editable-cell-input-wrapper">
                        <a-input v-model:value="editableData[record.SeatID].SeatNumber" @pressEnter="save(record.SeatID)" />
                        <check-outlined class="editable-cell-icon-check" @click="save(record.SeatID)" />
                    </div>
                    <div v-else class="editable-cell-text-wrapper">
                        {{ text || ' ' }}
                        <edit-outlined class="editable-cell-icon" @click="edit(record.SeatID)" />
                    </div>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <a-popconfirm v-if="dataSource.length" title="Sure to delete?" @confirm="onDelete(record.SeatID)">
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
            title: 'SeatID',
            dataIndex: 'SeatID',
        }, {
            title: 'SeatNumber',
            dataIndex: 'SeatNumber',
        }, {
            title: 'AircraftID',
            dataIndex: 'AircraftID',
        }, {
            title: 'operation',
            dataIndex: 'operation',
        }];
        const dataSource = ref([]);
        const count = computed(() => dataSource.value.length + 1);
        const editableData = reactive({});
        const edit = SeatID => {
            editableData[SeatID] = cloneDeep(dataSource.value.filter(item => SeatID === item.key)[0]);
        };
        const save = SeatID => {
            Object.assign(dataSource.value.filter(item => SeatID === item.SeatID)[0], editableData[SeatID]);
            delete editableData[SeatID];
        };
        // const onDelete = key => {
        //     dataSource.value = dataSource.value.filter(item => item.key !== key);
        // };
        const handleAdd = () => {
            const newData = {
                SeatID: `${count.value}`,
                SeatNumber: `Edward King ${count.value}`,
                AircraftID: `London, Park Lane no. ${count.value}`,
            };
            dataSource.value.push(newData);
        };

        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showSeat.php').then((response) => {
                console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };

        axios.get('http://localhost/databigvue/php/showSeat.php').then((response) => {
            console.log(response.data);
            dataSource.value = response.data[0].data;
        });

        const onDelete = SeatID => {
            console.log(SeatID);
            dataSource.value = dataSource.value.filter(item => item.SeatID !== SeatID);
            axios.post('http://localhost/databigvue/php/deluser.php', {
                SeatID
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
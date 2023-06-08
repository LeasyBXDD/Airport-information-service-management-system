<template>
    <a-table bordered :data-source="dataSource" :columns="columns">
        <template #bodyCell="{ column, text, record }">
            <template v-if="column.dataIndex === 'ReservationID'">
                <div class="editable-cell">
                    <div v-if="editableData[record.ReservationID]" class="editable-cell-input-wrapper">
                        <a-input v-model:value="editableData[record.ReservationID].name" @pressEnter="save(record.ReservationID)" />
                        <check-outlined class="editable-cell-icon-check" @click="save(record.ReservationID)" />
                    </div>
                    <div v-else class="editable-cell-text-wrapper">
                        {{ text || ' ' }}
                        <edit-outlined class="editable-cell-icon" @click="edit(record.ReservationID)" />
                    </div>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <a-popconfirm v-if="dataSource.length" title="Sure to delete?" @confirm="onDelete(record.ReservationID)">
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
            title: 'ReservationID',
            dataIndex: 'ReservationID',
        }, {
            title: 'CustomerID',
            dataIndex: 'CustomerID',
        }, {
            title: 'FlightID',
            dataIndex: 'FlightID',
        }, {
            title: 'ReservationDate',
            dataIndex: 'ReservationDate',
        }, {
            title: 'operation',
            dataIndex: 'operation',
        }];
        const dataSource = ref([]);
        const count = computed(() => dataSource.value.length + 1);
        const editableData = reactive({});
        const edit = ReservationID => {
            editableData[ReservationID] = cloneDeep(dataSource.value.filter(item => ReservationID === item.key)[0]);
        };
        const save = ReservationID => {
            Object.assign(dataSource.value.filter(item => ReservationID === item.ReservationID)[0], editableData[ReservationID]);
            delete editableData[ReservationID];
        };
        // const onDelete = key => {
        //     dataSource.value = dataSource.value.filter(item => item.key !== key);
        // };
        const handleAdd = () => {
            const newData = {
                ReservationID: `${count.value}`,
                Name: `Edward King ${count.value}`,
                ContactInfo: `London, Park Lane no. ${count.value}`,
            };
            dataSource.value.push(newData);
        };

        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showReservation.php').then((response) => {
                console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };

        axios.get('http://localhost/databigvue/php/showReservation.php').then((response) => {
            console.log(response.data);
            dataSource.value = response.data[0].data;
        });

        const onDelete = ReservationID => {
            console.log(ReservationID);
            dataSource.value = dataSource.value.filter(item => item.ReservationID !== ReservationID);
            axios.post('http://localhost/databigvue/php/deluser.php', {
                ReservationID
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
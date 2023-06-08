<template>
    <a-table bordered :data-source="dataSource" :columns="columns">
        <template #bodyCell="{ column, text, record }">
            <template v-if="column.dataIndex === 'AircraftID'">
                <div class="editable-cell">
                    <div v-if="editableData[record.AircraftID]" class="editable-cell-input-wrapper">
                        <a-input v-model:value="editableData[record.AircraftID].AircraftType"
                            @pressEnter="save(record.AircraftID)" />
                        <check-outlined class="editable-cell-icon-check" @click="save(record.AircraftID)" />
                    </div>
                    <div v-else class="editable-cell-text-wrapper">
                        {{ text || ' ' }}
                        <edit-outlined class="editable-cell-icon" @click="edit(record.AircraftID)" />
                    </div>
                </div>
            </template>
            <template v-else-if="column.dataIndex === 'operation'">
                <a-popconfirm v-if="dataSource.length" title="Sure to delete?" @confirm="onDelete(record.AircraftID)">
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
            title: 'AircraftID',
            dataIndex: 'AircraftID',
            width: '30%',
        }, {
            title: 'AircraftType',
            dataIndex: 'AircraftType',
        }, {
            title: 'NumberOfSeats',
            dataIndex: 'NumberOfSeats',
        }, {
            title: 'operation',
            dataIndex: 'operation',
        }];
        const dataSource = ref([]);
        const count = computed(() => dataSource.value.length + 1);
        const editableData = reactive({});
        const edit = AircraftID => {
            editableData[AircraftID] = cloneDeep(dataSource.value.filter(item => AircraftID === item.key)[0]);
        };
        const save = AircraftID => {
            Object.assign(dataSource.value.filter(item => AircraftID === item.AircraftID)[0], editableData[AircraftID]);
            delete editableData[AircraftID];
        };
        // const onDelete = key => {
        //     dataSource.value = dataSource.value.filter(item => item.key !== key);
        // };
        const handleAdd = () => {
            const newData = {
                AircraftID: `${count.value}`,
                AircraftType: `Edward King ${count.value}`,
                NumberOfSeats: `London, Park Lane no. ${count.value}`,
            };
            dataSource.value.push(newData);
        };

        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showAircraft.php').then((response) => {
                console.log(response.data);
                dataSource.value = response.data[0].data;
            });
        };

        axios.get('http://localhost/databigvue/php/showAircraft.php').then((response) => {
            console.log(response.data);
            dataSource.value = response.data[0].data;
        });

        const onDelete = AircraftID => {
            console.log(AircraftID);
            dataSource.value = dataSource.value.filter(item => item.AircraftID !== AircraftID);
            axios.post('http://localhost/databigvue/php/deluser.php', {
                AircraftID
            }, {
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
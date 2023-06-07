<template>
    <a-button class="editable-add-btn" style="margin-bottom: 8px" @click="handleAdd">添加</a-button>
    <a-table bordered :data-source="dataSource" :columns="columns">
        <template #bodyCell="{ column, text, record }">
            <template v-if="column.dataIndex === 'FlightNumber'">
                <div class="editable-cell">
                    <div v-if="editableData[record.key]" class="editable-cell-input-wrapper">
                        <a-input v-model:value="editableData[record.key].FlightNumber" @pressEnter="save(record.key)" />
                        <check-outlined class="editable-cell-icon-check" @click="save(record.key)" />
                    </div>
                    <div v-else class="editable-cell-text-wrapper">
                        {{ text || ' ' }}
                        <edit-outlined class="editable-cell-icon" @click="edit(record.key)" />
                    </div>
                </div>
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
        const columns = [
            {
                title: 'FlightID',
                dataIndex: 'FlightID',
                key: 'FlightID',
            },
            {
                title: 'FlightNumber',
                dataIndex: 'FlightNumber',
                key: 'FlightNumber',
            },
            {
                title: 'DepartureTime',
                dataIndex: 'DepartureTime',
                key: 'DepartureTime',
            },
            {
                title: 'ArrivalTime',
                dataIndex: 'ArrivalTime',
                key: 'ArrivalTime',
            },
            {
                title: 'FlightStatus',
                dataIndex: 'FlightStatus',
                key: 'FlightStatus',
            },
            {
                title: 'AircraftID',
                dataIndex: 'AircraftID',
                key: 'AircraftID',
            },
            {
                title: 'DepartureAirportCode',
                dataIndex: 'DepartureAirportCode',
                key: 'DepartureAirportCode',
            },
            {
                title: 'ArrivalAirportCode',
                dataIndex: 'ArrivalAirportCode',
                key: 'ArrivalAirportCode',
            },
        ];
        const dataSource = ref([]);
        const count = computed(() => dataSource.value.length + 1);
        const editableData = reactive({});
        const edit = (key) => {
            editableData[key] = cloneDeep(
                dataSource.value.filter((item) => key === item.key)[0]
            );
        };
        const save = (key) => {
            Object.assign(
                dataSource.value.filter((item) => key === item.key)[0],
                editableData[key]
            );
            delete editableData[key];
        };

        const handleAdd = () => {
            let newData = {
                FlightID: `${count.value}`,
                FlightNumber: `user${count.value}`,
                DepartureTime: `user${count.value}@example.com`,
                ArrivalTime: `user${count.value}@example.com`,
                FlightStatus: `user${count.value}@example.com`,
                AircraftID: `user${count.value}@example.com`,
                DepartureAirportCode: `user${count.value}@example.com`,
                ArrivalAirportCode: `Last${count.value}`,
            };

            axios.post('http://localhost/databigvue/php/adduser.php', {
                FlightID: `${count.value}`,
                FlightNumber: `user${count.value}`,
                DepartureTime: `user${count.value}@example.com`,
                ArrivalTime: `user${count.value}@example.com`,
                FlightStatus: `user${count.value}@example.com`,
                AircraftID: `user${count.value}@example.com`,
                DepartureAirportCode: `user${count.value}@example.com`,
                ArrivalAirportCode: `Last${count.value}`,
            },{
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then((response) => {
                    console.log(response.data);
                    if (response.data[0].code === 1) {
                        newData.key = response.data[0].data.FlightID;
                        dataSource.value.push(newData);
                        count.value += 1;
                    } else {
                        console.error(response.data);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        };

        axios.get('http://localhost/databigvue/php/showFlight.php').then((response) => {
            console.log(response.data);
            dataSource.value = response.data[0].data;
        });

        return {
            columns,
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
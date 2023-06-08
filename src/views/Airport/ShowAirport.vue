<template>
    <a-table :data-source="data.value" :columns="columns">
        <template #headerCell="{ column }">
            <template v-if="column.key === 'Name'">
                <span style="color: #1890ff">Name</span>
            </template>
        </template>
        <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
            <div style="padding: 8px">
                <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`" :value="selectedKeys[0]"
                    style="width: 188px; margin-bottom: 8px; display: block"
                    @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
                    @pressEnter="handleSearch(selectedKeys, confirm, column.dataIndex)" />
                <a-button type="primary" size="small" style="width: 90px; margin-right: 8px"
                    @click="handleSearch(selectedKeys, confirm, column.dataIndex)">
                    <template #icon>
                        <SearchOutlined />
                    </template>
                    Search
                </a-button>
                <a-button size="small" style="width: 90px" @click="handleReset(clearFilters)">
                    Reset
                </a-button>
            </div>
        </template>
        <template #customFilterIcon="{ filtered }">
            <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
        </template>
        <template #bodyCell="{ text, column }">
            <span v-if="searchText && searchedColumn === column.dataIndex">
                <template v-for="(fragment, i) in text
                    .toString()
                    .split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))">
                    <mark v-if="fragment.toLowerCase() === searchText.toLowerCase()" :key="i" class="highlight">
                        {{ fragment }}
                    </mark>
                    <template v-else>{{ fragment }}</template>
                </template>
            </span>
        </template>
    </a-table>
</template>

<script>
import { SearchOutlined } from '@ant-design/icons-vue';
import { defineComponent, reactive, ref, toRefs } from 'vue';
import axios from 'axios';

export default defineComponent({
    components: {
        SearchOutlined,
    },
    setup() {
        const state = reactive({
            searchText: '',
            searchedColumn: '',
        });
        const searchInput = ref();
        const columns = [
            {
                title: 'Name',
                dataIndex: 'Name',
                key: 'Name',
                customFilterDropdown: true,
                onFilter: (value, record) =>
                    record.Name.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownVisibleChange: (visible) => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            },
            {
                title: 'CustomerID',
                dataIndex: 'CustomerID',
                key: 'CustomerID',
            },
            {
                title: 'ContactInfo',
                dataIndex: 'ContactInfo',
                key: 'ContactInfo',
                customFilterDropdown: true,
                onFilter: (value, record) =>
                    record.address.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownVisibleChange: (visible) => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            },
        ];
        const data = reactive([]); // 声明响应式对象
        const fetchData = () => {
            axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
                console.log(response.data);
                data.value = response.data[0].data;
            });
        };
        axios.get('http://localhost/databigvue/php/showuser.php').then((response) => {
            console.log(response.data);
            data.value = response.data[0].data;
        });
        console.log("sss",data);
        const handleSearch = (selectedKeys, confirm, dataIndex) => {
            confirm();
            state.searchText = selectedKeys[0];
            state.searchedColumn = dataIndex;
        };
        const handleReset = (clearFilters) => {
            clearFilters({
                confirm: true,
            });
            state.searchText = '';
        };
        return {
            fetchData,
            data,
            columns,
            handleSearch,
            handleReset,
            searchInput,
            ...toRefs(state),
        };
    },
});
</script>

<style scoped>
.highlight {
    background-color: rgb(255, 192, 105);
    padding: 0px;
}
</style>
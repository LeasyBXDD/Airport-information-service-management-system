<template>
    <a-table :columns="columns" :data-source="data" @change="onChange" />
</template>
  
<script>
import { defineComponent, ref, onMounted } from "vue";
import axios from "axios";

const columns = [
    {
        title: "Name",
        dataIndex: "name"
    },
    {
        title: "Chinese Score",
        dataIndex: "chinese",
        sorter: {
            compare: (a, b) => a.chinese - b.chinese,
            multiple: 3
        }
    },
    {
        title: "Math Score",
        dataIndex: "math",
        sorter: {
            compare: (a, b) => a.math - b.math,
            multiple: 2
        }
    },
    {
        title: "English Score",
        dataIndex: "english",
        sorter: {
            compare: (a, b) => a.english - b.english,
            multiple: 1
        }
    }
];

export default defineComponent({
    setup() {
        const data = ref([]);

        const onChange = (pagination, filters, sorter, extra) => {
            console.log("params", pagination, filters, sorter, extra);
        };

        onMounted(async () => {
            try {
                const response = await axios.get("/api/users");
                data.value = response.data;
            } catch (error) {
                console.error(error);
            }
        });

        return {
            data,
            columns,
            onChange
        };
    }
});
</script>
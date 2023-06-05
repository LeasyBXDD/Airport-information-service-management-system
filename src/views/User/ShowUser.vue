<template>
    <a-table :columns="columns" :data-source="data" @change="onChange" />
</template>
  
<script>
import { defineComponent, ref, onMounted } from "vue";
import axios from "axios";

const columns = [
    {
        title: "CustomerID",
        dataIndex: "CustomerID"
    },
    {
        title: "Name",
        dataIndex: "Name",
        sorter: {
            compare: (a, b) => a.chinese - b.chinese,
            multiple: 3
        }
    },
    {
        title: "ContactInfo",
        dataIndex: "ContactInfo",
        sorter: {
            compare: (a, b) => a.math - b.math,
            multiple: 2
        }
    },
];

export default defineComponent({
    setup() {
        const data = ref([]);

        const onChange = (pagination, filters, sorter, extra) => {
            console.log("params", pagination, filters, sorter, extra);
        };

        onMounted(async () => {
            try {
                const response = await axios.get("http://localhost/databigvue/php/showuser.php");
                data.value = response.data[0].data;
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
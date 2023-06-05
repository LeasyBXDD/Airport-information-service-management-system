<template>
    <div style="margin-top: 40px;">
        <div class="registerForm">
            <a-form :model="formState" name="basic" :label-col="{ span: 8 }" :wrapper-col="{ span: 16 }" autocomplete="off"
                @finish="onFinish" @finishFailed="onFinishFailed">
                <a-form-item label="昵称" name="username"
                    :rules="[{ required: true, message: 'Please input your username!' }]">
                    <a-input v-model:value="formState.username" />
                </a-form-item>

                <a-form-item label="密码" name="password"
                    :rules="[{ required: true, message: 'Please input your password!' }]">
                    <a-input-password v-model:value="formState.password" />
                </a-form-item>

                <a-form-item :wrapper-col="{ offset: 8, span: 16 }">
                    <a-button type="primary" html-type="submit" style="width: 100%;">注册</a-button>
                </a-form-item>
            </a-form>
        </div>
    </div>
</template>

<script>
import { defineComponent, reactive } from 'vue';
export default {
    name: "LoginView",

    setup() {
        const formState = reactive({
            username: '',
            password: '',
            remember: true,
        });
        const onFinish = values => {
            console.log('Success:', values);
        };
        const onFinishFailed = errorInfo => {
            console.log('Failed:', errorInfo);
        };
        return {
            formState,
            onFinish,
            onFinishFailed,
        };
    },

};
</script>

<style scoped>
.registerForm {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
<template>
    <div class="LoginFormCenter">
        <a-form :model="formState" name="normal_login" class="login-form" @finish="onFinish" @finishFailed="onFinishFailed">
            <a-form-item label="昵称" name="username"
                :rules="[{ required: true, message: '请输入昵称' }]">
                <a-input v-model:value="formState.username">
                    <template #prefix>
                        <UserOutlined class="site-form-item-icon" />
                    </template>
                </a-input>
            </a-form-item>

            <a-form-item label="密码" name="password"
                :rules="[{ required: true, message: '请输入密码' }]">
                <a-input-password v-model:value="formState.password">
                    <template #prefix>
                        <LockOutlined class="site-form-item-icon" />
                    </template>
                </a-input-password>
            </a-form-item>

            <a-form-item>
                <a-form-item name="remember" style="float: right;">
                    <a-checkbox v-model:checked="formState.remember">自动登录</a-checkbox>
                </a-form-item>
            </a-form-item>

            <a-form-item style="margin-top: -24px;">
                <a-button :disabled="disabled" type="primary" html-type="submit" style="width:100%;">
                    登录
                </a-button>
            </a-form-item>
        </a-form>
    </div>
</template>
<script>
import { defineComponent, reactive, computed } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';
export default defineComponent({
    components: {
        UserOutlined,
        LockOutlined,
    },
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
        const disabled = computed(() => {
            return !(formState.username && formState.password);
        });
        return {
            formState,
            onFinish,
            onFinishFailed,
            disabled,
        };
    },
});
</script>
<style scoped>
.LoginFormCenter {
    margin-top: 50px;
    display: flex;
    justify-content: center;
}

#components-form-demo-normal-login .login-form {
    max-width: 300px;
}

#components-form-demo-normal-login .login-form-forgot {
    float: right;
}

#components-form-demo-normal-login .login-form-button {
    width: 100%;
}
</style>
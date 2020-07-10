<template>
    <layout>

        <div class="mt-8">
            <div class="flex">
                <h2 class="text-3xl text-indigo-500 font-bold">المستخدمين /<span class="text-gray-700"> أنشاء</span></h2>
            </div>
            <!-- md:max-w-3xl -->
            <base-panel class=" mt-4">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <base-input label="الأسم" name="name" v-model="form.name" :error="$page.errors.name" required></base-input>
                        </div>
                        <div>
                            <base-input label="أسم المستخدم" name="username" v-model="form.username" :error="$page.errors.username" required></base-input>
                        </div>
                        <div>
                            <base-input type="number" label="رقم الهاتف" name="phone" v-model="form.phone" :error="$page.errors.phone" required></base-input>
                        </div>
                        <div>
                            <base-input type="number" label="رقم الهاتف الأضافي" name="alt_phone" v-model="form.alt_phone" :error="$page.errors.alt_phone" required></base-input>
                        </div>
                        <div>
                            <base-input label="العنوان" name="address" v-model="form.address" :error="$page.errors.address" required></base-input>
                        </div>
                        <div>
                            <base-input type="number" label="الرصيد" name="balance" v-model="form.balance" :error="$page.errors.balance" required></base-input>
                        </div>
                        <div>
                            <base-input label="كلمة المرور" type="password" v-model="form.password" :error="$page.errors.password" required></base-input>
                        </div>
                        <base-input label="تأكيد كلمة المرور" type="password" v-model="form.password_confirmation" :error="$page.errors.password_confirmation" required></base-input>
                    </div>
                    <div class="flex justify-end mt-4">
                        <base-button primary>أنشاء مستخدم</base-button>
                    </div>
                </form>
            </base-panel>

        </div>

    </layout>
</template>

<script>
    import Layout from "../../../Shared/Layout";

    export default {
        components: {Layout},
        data() {
            return {
                form: {
                    name: '',
                    username: '',
                    phone:'',
                    alt_phone:'',
                    address:'',
                    balance:'',
                    password: '',
                    password_confirmation: '',
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post('/dashboard/users', this.form);
            }
        }
    }
</script>

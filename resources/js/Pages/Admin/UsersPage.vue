<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
</script>
<script>
export default {
    data() {
        return {
            users: [],
        };
    },
    mounted() {
        axios.get('/api/users')
            .then((response) => this.users = response.data)
            .catch(error => {console.log(error.response.data.message)});
    },
    methods: {
        updateUser(user) {
            axios.put(`/api/users/update/${user.id}`, {
                is_verified: user.is_verified,
                is_teacher: user.is_teacher
            },{
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
                .then(response => {console.log(response.data.message)})
                .catch(error => {console.log(error.response.data.message)})
        },
    },
}
</script>
<template>
    <Head title="Управление пользователями"></Head>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <table>
                    <thead>
                    <tr>
                        <th>Ф.И.О.</th>
                        <th>E-mail</th>
                        <th>Пароль</th>
                        <th>Подтвержден</th>
                        <th>Учитель</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.password }}</td>
                            <td><input type="checkbox" v-model="user.is_verified" @change="updateUser(user)"></td>
                            <td><input type="checkbox" v-model="user.is_teacher" @change="updateUser(user)"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

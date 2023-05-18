<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import axios from "axios";
</script>
<script>
export default {
    data() {
        return {
            searchQuery: '',
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
            axios.put(`/api/users/update/${user.id}/`, {
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
    computed: {
        filteredUsers() {
            if (!this.searchQuery) {
                return this.users
            }
            return this.users.filter(user =>
                user.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                || user.email.toLowerCase().includes(this.searchQuery.toLowerCase())
            )
        }
    },
}
</script>
<template>
    <Head title="Управление пользователями"></Head>
    <AuthenticatedLayout>
        <div class="form-group mx-sm-3 mb-2 bg-dark border border-dark rounded">
            <input type="text" placeholder="Поиск по Ф.И.О. и e-mail" v-model="searchQuery">
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <table>
                    <thead>
                    <tr>
                        <th class="col-auto">Ф.И.О.</th>
                        <th class="col-auto">E-mail</th>
                        <th class="col-auto">Пароль</th>
                        <th class="col-auto">Подтвержден</th>
                        <th class="col-auto">Учитель</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in filteredUsers" :key="user.id">
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

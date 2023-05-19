<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
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

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="flex-wrap justify-content-center rounded-5">
                    <input class="rounded-pill w-auto" type="text" placeholder="Поиск по Ф.И.О. и e-mail" v-model="searchQuery">
                </div>
                <div class="col-auto">
                    <table class="table-auto scroll-m-0.5 overscroll-y-auto">
                        <thead>
                        <tr >
                            <th>Ф.И.О.</th>
                            <th>E-mail</th>
                            <th>Подтвержден</th>
                            <th>Учитель</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in filteredUsers" :key="user.id" class="row-auto">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td><input class="justify-center" type="checkbox" v-model="user.is_verified" @change="updateUser(user)"></td>
                            <td><input class="items-center" type="checkbox" v-model="user.is_teacher" @change="updateUser(user)"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <Link :href="route('admin.users.add')" :ref="route('admin.users.add')" class="btn btn-outline-secondary">
                    Добавить пользователя
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

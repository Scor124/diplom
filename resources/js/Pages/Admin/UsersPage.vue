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
        deleteUser(user){
            if(confirm(`Вы точно хотите удалить ${user.name}?`)){
                axios.delete(`/api/users/delete/${user.id}`)
                    .then(response => {
                        axios.get('/api/users')
                            .then((response) => this.users = response.data)
                            .catch(error => {console.log(error.response.data.message)});
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
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
                <div class="row-auto">
                    <div class="col-auto float-md-start">
                        <table class="table mx-auto scroll-m-0.5 overscroll-y-auto table-striped table-hover text-gray-300">
                            <thead>
                                <tr>
                                    <th>Ф.И.О.</th>
                                    <th>E-mail</th>
                                    <th>Подтвержден</th>
                                    <th>Учитель</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in filteredUsers" :key="user.id" class="row-auto">
                                    <td class="px-3">{{ user.name }}</td>
                                    <td class="px-3">{{ user.email }}</td>
                                    <td class="text-center"><input type="checkbox" v-model="user.is_verified" @change="updateUser(user)"></td>
                                    <td class="text-center"><input type="checkbox" v-model="user.is_teacher" @change="updateUser(user)"></td>
                                    <td class="px-10"><button class="btn btn-outline-danger hover:text-red-500 border-red-700" @click="deleteUser(user)">Удалить</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-auto">
                        <div class="form-outline">
                            <input class="form-control" type="search"  placeholder="Поиск по Ф.И.О. и e-mail" v-model="searchQuery">
                            <label for="search" class="form-label"/>
                        </div>
                        <div class="btn btn-outline-secondary hover:bg-green-500 rounded-5">
                            <Link :href="route('admin.users.add')" :ref="route('admin.users.add')" >
                                Добавить пользователя
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

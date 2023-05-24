<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import axios from "axios";
</script>
<script>

import UserAddPage from "@/Pages/Admin/UserAddPage.vue";
export default {
    components:{UserAddPage},
    data() {
        return {
            showModal: false,
            searchQuery: '',
            users: [],
        };
    },
    mounted() {
        axios.get('/api/users')
            .then((response) => this.users = response.data)
            .catch(error => {console.log(error.response.data.message)});
    },
    beforeDestroy() {
        // Удаляем обработчик событий при уничтожении компонента
        document.removeEventListener('keydown', this.handleTabKey);
    },
    methods: {
        handleTabKey(event) {
            if (this.showModal && event.key === 'Tab') {
                event.preventDefault();
            }
        },
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
        <div v-if="showModal"  style="position: fixed;    z-index: 9999;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-gray-600 rounded-5" style="position: absolute;    top: 50%;    left: 50%;    transform: translate(-50%, -50%);        border-radius: 5px;    padding: 20px;">
                <div class="float-end">
                    <button class="btn btn-close hover:bg-red-700" @click="showModal = false"></button>
                </div>
                <UserAddPage @close="axios.get('/api/users')
                            .then((response) => this.users = response.data)
                            .catch(error => {console.log(error.response.data.message)});"/>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="container-fluid">
                    <div class="col-auto">
                        <div class="btn btn-outline-success hover:bg-green-500 rounded-5 float-start">
                            <button @click="showModal = true">Добавить пользователя</button>
                        </div>
                        <div class="float-end w-2/5">
                            <input class="w-full rounded-pill" type="search"  placeholder="Поиск по Ф.И.О. и e-mail" v-model="searchQuery">
                        </div>
                    </div>
                    <div class="mt-10 rounded-5 ">
                        <table class="table mx-auto scroll-m-0.5 overscroll-y-auto table-striped table-bordered mt-4 table-hover bg-gray-300 text-black">
                            <thead>
                                <tr>
                                    <th class="text-center">Ф.И.О.</th>
                                    <th class="text-center">E-mail</th>
                                    <th class="text-center">Подтвержден</th>
                                    <th class="text-center">Учитель</th>
                                    <th class="text-center">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in filteredUsers" :key="user.id" class="row-auto align-content-center">
                                    <td class="px-3 align-middle">{{ user.name }}</td>
                                    <td class="px-3 align-middle">{{ user.email }}</td>
                                    <td class="text-center align-middle"><input type="checkbox" v-model="user.is_verified" @change="updateUser(user)"></td>
                                    <td class="text-center align-middle"><input type="checkbox" v-model="user.is_teacher" @change="updateUser(user)"></td>
                                    <td class="px-10 align-middle"><button class="btn btn-outline-danger hover:text-red-500 border-red-700" @click="deleteUser(user)">Удалить</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

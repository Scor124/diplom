<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import axios from "axios";
</script>

<script>
import StudentsAddPage from "@/Pages/Admin/StudentsAddPage.vue";
export default {
    components:{StudentsAddPage},
    data() {
        return {
            showModal: false,
            groups: [],
            selectedGroup: null,
            searchGroup: '',
            searchStudents: '',
            students: [],
        };
    },
    mounted() {
        axios.get('/api/classes')
            .then((response) => this.groups = response.data)
            .catch(error => {console.log(error.response.data.message)});
    },
    beforeDestroy() {
        // Удаляем обработчик событий при уничтожении компонента
        document.removeEventListener('keydown', this.handleTabKey);
    },
    methods: {
        selectedGroup(group) {
            this.selectedGroup = group;
            axios.get(`/api/classes/${group.id}/students`)
                .then((response) => this.students = response.data)
                .catch(error => {console.log(error.response.data.message)});
        },
        handleTabKey(event) {
            if (this.showModal && event.key === 'Tab') {
                event.preventDefault();
            }
        },
        updateStudents(student) {
            axios.put(`/api/students/update/${student.id}/`, {
                is_verified: student.is_verified,
                is_teacher: student.is_teacher
            },{
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
                .then(response => {console.log(response.data.message)})
                .catch(error => {console.log(error.response.data.message)})
        },
        deleteUser(student){
            if(confirm(`Вы точно хотите удалить ${student.name}?`)){
                axios.delete(`/api/students/delete/${student.id}`)
                    .then(response => {
                        axios.get('/api/students')
                            .then((response) => this.students = response.data)
                            .catch(error => {console.log(error.response.data.message)});
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    },
    computed: {
        filtredGroups() {
            if (!this.searchGroup) {
                return this.groups
            }
            return this.groups.filter(group =>
                group.name.toLowerCase().includes(this.searchGroup.toLowerCase())
            )
        },
        filteredStudents() {
            if (!this.searchStudents) {
                return this.students
            }
            return this.students.filter(student =>
                student.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            )
        }
    },
}
</script>
<template>
    <Head title="Управление студентами"></Head>
    <AuthenticatedLayout>
        <div v-if="showModal"  style="position: fixed;    z-index: 9999;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-gray-600 rounded-5" style="position: absolute;    top: 50%;    left: 50%;    transform: translate(-50%, -50%);        border-radius: 5px;    padding: 20px;">
                <div class="float-end">
                    <button class="btn btn-close hover:bg-red-700" @click="showModal = false"></button>
                </div>
                <StudentsAddPage :groupId="selectedGroup.id" @close="axios.get('/api/students')
                            .then((response) => this.students = response.data)
                            .catch(error => {console.log(error.response.data.message)});"/>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div>
                    <div class="col-auto">

                        <div class="float-end w-2/5">
                            <input class="w-full rounded-pill" type="search"  placeholder="Поиск по Ф.И.О." v-model="searchStudents">
                        </div>
                    </div>
                    <div class="mt-10 rounded-5 row container-fluid">
                            <div class="col-md-6 w-1/5">
                                <h2>Groups</h2>
                                <div>
                                    <input class="w-full rounded-pill" type="search"  placeholder="Поиск по Ф.И.О." v-model="searchGroup">
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="group in filtredGroups" :key="group.id">
                                            <td>
                                                <button class="btn btn-info" @click="selectedGroup(group)">{{ group.name }}</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 w-auto">
                                <h2>Students</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Class ID</th>
                                            <th>
                                                <div class="btn btn-outline-success hover:bg-green-500 rounded-5 float-start">
                                                    <button @click="showModal = true">Добавить пользователя</button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="student in filteredStudents" :key="student.id">
                                            <td>{{ student.id }}</td>
                                            <td>{{ student.name }}</td>
                                            <td>{{ student.class_id }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<!--
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
-->

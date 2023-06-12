<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import axios from "axios";
</script>

<script>
import StudentsAddPage from "@/Pages/Admin/StudentsAddPage.vue";
import {data} from "autoprefixer";
export default {
    props:{
        groupId: {
            type: Number,
        }
    },
    components:{StudentsAddPage},
    data() {
        return {
            showModal: false,
            selectedGroup: this.groupId,
            searchStudents: '',
            students: [],
        };
    },
    mounted() {
        axios.get('/classes/' + this.selectedGroup + '/students')
            .then((response) => this.students = response.data)
            .catch(error => {console.log(error.response.data.message)});
    },
    beforeDestroy() {
        document.removeEventListener('keydown', this.handleTabKey);
    },
    methods: {
        passwordReset(student){
            axios.put(`/users/update/${student.id}/`, {
                password: '123456'
            })
                .then(response => {console.log(response.data.message)})
                .catch(error => {console.log(error.response.data.message)})
        },
        handleTabKey(event) {
            if (this.showModal && event.key === 'Tab') {
                event.preventDefault();
            }
        },
        updateStudents(student) {
            let UserID = student.id;
            axios.put(`/users/update/${UserID}/`, {
                name: student.name
            })
                .then(response => {console.log(response.data.message)})
                .catch(error => {console.log(error.response.data.message)})
        },  // Обновить студента
        deleteUser(student){
            if(confirm(`Вы точно хотите удалить ${student.name}?`)){
                let UserID = student.UserID;
                axios.delete(`/student/delete/${student.id}`)
                    .then().catch(error => {
                        console.log(error);
                    });
            }
        }
    },
    computed: {
        filteredStudents() {
            if (!this.searchStudents) {
                return this.students
            }
            return this.students.filter(student =>
                student.name.toLowerCase().includes(this.searchStudents.toLowerCase())
            )
        },
    },
}
</script>
<template>
    <Head title="Управление студентами"></Head>
    <AuthenticatedLayout>
        <div v-if="showModal" style="position: fixed;    z-index: 9999;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-gray-600 rounded-5" style="position: absolute;    top: 50%;    left: 50%;    transform: translate(-50%, -50%);        border-radius: 5px;    padding: 20px;">
                <div class="float-end">
                    <button class="btn btn-close hover:bg-red-700" @click="showModal = false"></button>
                </div>
                <StudentsAddPage :groupId="groupId" />
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div>
                    <div class="mt-10 rounded-5 container-fluid">
                            <div class="w-auto bg-gray-600 text-black rounded-5 border-1 p-2">
                                <div class="col m-3">
                                    <h6 class="text-center font-semibold font">Студенты</h6>
                                    <div>
                                        <div class="float-start w-3/5">
                                            <input class="w-full rounded-pill" type="search"  placeholder="Поиск по Ф.И.О." v-model="searchStudents">
                                        </div>
                                        <div class="btn btn-outline-success hover:bg-green-500 rounded-5 float-end">
                                            <button @click="showModal = true" >Добавить студента</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped w-full">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-3/7">Ф.И.О. студентов</th>
                                            <th class="text-center w-2/7">E-mail</th>
                                            <th class="text-center w-2/7">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="student in filteredStudents" :key="student.id">
                                            <td ><input class="class=my-auto w-full" v-model="student.name" type="text" @change="updateStudents(student)"></td>
                                            <td class="my-auto mx-auto">{{ student.email }}</td>
                                            <td>
                                                <button class="btn btn-outline-info hover:text-white-500 border-blue-700" @click="passwordReset(student)">Сбросить пароль</button>
                                                <button class="btn btn-outline-danger hover:text-red-500 border-red-700 m-2" @click="deleteUser(student)" disabled>Удалить</button>
                                            </td>
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

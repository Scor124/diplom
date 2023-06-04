<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import axios from "axios";
</script>

<script>
import StudentsAddPage from "@/Pages/Admin/StudentsAddPage.vue";
import {data} from "autoprefixer";
export default {
    components:{StudentsAddPage},
    data() {
        return {
            showModal: false,
            groups: [],
            selectedGroup: 0,
            searchGroup: '',
            searchStudents: '',
            students: [],
        };
    },
    mounted() {
        axios.get('/classes')
            .then((response) => this.groups = response.data)
            .catch(error => {console.log(error.response.data.message)});
    },
    beforeDestroy() {
        // Удаляем обработчик событий при уничтожении компонента
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
        },      //
        updateStudents(student) {
            let UserID = student.id;
            /*
            axios.get(`/api/users/${UserID}`)
                .then(response => UserID = response.data.id)
                .catch(error => {console.log(error.response.data.message)});
             */
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
                    .then(this.groupChanged)
                    .catch(error => {
                        console.log(error);
                    });
                /*
                axios.delete(`/users/delete/${UserID}`)
                    .then(this.groupChanged())
                    .catch(error => {
                        console.log(error);
                    });
                 */

            }
        }        // Удалить пользователя (опционально)
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
                student.name.toLowerCase().includes(this.searchStudents.toLowerCase())
            )
        },
        groupChanged(){
            axios.get('/classes/' + this.selectedGroup + '/students')
                .then((response) => this.students = response.data)
                .catch(error => {console.log(error.response.data.message)});
        },            // При изменение выбора группы
    },
}
</script>
<template>
    <Head title="Управление студентами"></Head>
    <AuthenticatedLayout>
        <div v-if="showModal && selectedGroup!==0" style="position: fixed;    z-index: 9999;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-gray-600 rounded-5" style="position: absolute;    top: 50%;    left: 50%;    transform: translate(-50%, -50%);        border-radius: 5px;    padding: 20px;">
                <div class="float-end">
                    <button class="btn btn-close hover:bg-red-700" @click="showModal = false; groupChanged"></button>
                </div>
                <StudentsAddPage :groupId="selectedGroup" />
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div>

                    <div class="mt-10 rounded-5 row container-fluid">
                            <div class="col-md-6 w-1/5 bg-gray-600 rounded-5 px-3">
                                <div class="m-1">
                                    <input class="w-full rounded-pill" type="search"  placeholder="Поиск по названию" v-model="searchGroup">
                                </div>
                                <div class="m-4" id="group-selection">
                                    <label for="group-select">Выбрать группу:</label>
                                    <select class="form-select rounded-5" v-model="selectedGroup" @change="groupChanged">
                                        <option disabled value="0">Выберите группу</option>
                                        <option v-for="group in filtredGroups" :key="group.id" :value="group.id">{{ group.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 w-auto bg-gray-600 text-black">
                                <div class="col-auto m-3">
                                    <h4 class="text-center font-semibold">Студенты</h4>
                                    <div class="float-end w-2/5">
                                        <input class="w-full rounded-pill" type="search"  placeholder="Поиск по Ф.И.О." v-model="searchStudents">
                                    </div>
                                </div>

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ф.И.О. студентов</th>
                                            <th>E-mail</th>
                                            <th class="text-center">Действия</th>
                                            <th>
                                                <div v-if="selectedGroup!==0" class="btn btn-outline-success hover:bg-green-500 rounded-5 float-start">
                                                    <button @click="showModal = true" >Добавить студента</button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="student in filteredStudents" :key="student.id">
                                            <td><input v-model="student.name" type="text" @change="updateStudents(student)"></td>
                                            <td>{{ student.email }}</td>
                                            <td>
                                                <button class="btn btn-outline-info hover:text-white-500 border-blue-700 m-2" @click="passwordReset(student)">Сбросить пароль</button>
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

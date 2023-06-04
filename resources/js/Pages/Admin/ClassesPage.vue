<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import axios from "axios";
</script>
<script>
import ClassesAddPage from "@/Pages/Admin/ClassesAddPage.vue";
export default{
    components:{ClassesAddPage},
    data() {
        return {
            showModal: false,
            searchQuery: '',
            classes: [],
            selectedGroup: null,
        };
    },
    mounted() {
        axios.get('/classes')
            .then((response) => this.classes = response.data)
            .catch(error => {console.log(error.response.data.message)});
        console.log(this.classes)
    },
    beforeDestroy() {
        // Удаляем обработчик событий при уничтожении компонента
        document.removeEventListener('keydown', this.handleTabKey);
    },
    methods: {
        seeSubjects(id){
            axios.get(`/admin/classes/${id}/subjects`).then((response)=> console.log(response.data)).catch(error => console.log(error));
            //route('class.subjects',{'groupId': id});
            window.location.href = `/admin/classes/${id}/subjects`;
        },
        updateGroupList(){
            axios.get('/classes')
                .then((response) => this.classes = response.data)
                .catch(error => {console.log(error.response.data.message)});
        },
        handleTabKey(event) {
            if (this.showModal && event.key === 'Tab') {
                event.preventDefault();
            }
        },
        updateGroup(group) {
            axios.put(`/classes/update/${group.id}/`, {
                name: group.name
            },{
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
                .then(response => {console.log(response.data.message)})
                .catch(error => {console.log(error.response.data.message)})
        },
        deleteGroup(group){
            if(confirm(`Вы точно хотите удалить ${group.name}?`)){
                axios.delete(`/classes/delete/${group.id}`)
                    .then(response => {
                        axios.get('/classes')
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
        filteredGroups() {
            if (!this.searchQuery) {
                return this.classes
            }
            return this.classes.filter(classes => classes.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
        }
    },
}
</script>
<template>
    <Head title="Управление классами"></Head>
    <AuthenticatedLayout class="dark:bg-dots-lighter">
        <div v-if="showModal"  style="position: fixed;    z-index: 9999;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-gray-600 rounded-5" style="position: absolute;    top: 50%;    left: 50%;    transform: translate(-50%, -50%);        border-radius: 5px;    padding: 20px;">
                <div class="float-end">
                    <button class="btn btn-close hover:bg-red-700" @click="showModal = false;updateGroupList"></button>
                </div>
                <ClassesAddPage/>
            </div>
        </div>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-transparent" >
                <div class="container-fluid">
                    <div class="col-auto">
                        <div class="btn btn-outline-success hover:bg-green-500 rounded-5 float-start">
                            <button @click="showModal = true">Добавить группу</button>
                        </div>
                        <div class="float-end w-2/5">
                            <input class="w-full rounded-pill" type="search"  placeholder="Поиск по названию" v-model="searchQuery">
                        </div>
                    </div>
                    <div class="mt-10 rounded-5">
                        <table class="table mx-auto scroll-m-0.5 overscroll-y-auto table-striped table-hover bg-gray-300 text-black table-bordered mt-4">
                            <thead>
                            <tr>
                                <th class="text-center">Название</th>
                                <th class="text-center">Дата создания</th>
                                <th class="text-center">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="group in filteredGroups" :key="group.id" class="row-auto" @select="selectedGroup = group">
                                <td class="px-3 align-middle">{{ group.name }}</td>
                                <td class="px-3 align-middle">{{ group.formation_date }}</td>
                                <td class="px-10 align-middle">
                                    <button class="btn btn-outline-primary hover:text-blue-500 m-2" @click="seeSubjects(group.id)">Перейти к предметам</button>
                                    <button class="btn btn-outline-danger hover:text-red-500  m-2" @click="deleteGroup(group)">Удалить</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

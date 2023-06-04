<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SubjectAddPage from "@/Pages/Admin/SubjectAddPage.vue";
</script>
<script>
export default {
    props:{
        groupId: {
            type: Number,
        }
    },
    data() {
        return {
            searchQuery: '',
            showModal: false,
            subjects: []
        }
    },
    mounted() {
        axios.get(`/classes/${this.groupId}/subjects`)
            .then((response) => {this.subjects = response.data})
            .catch((error) => console.log(error.message));
    },
    methods:{
        getSubjects(){
            axios.get(`/classes/${this.groupId}/subjects`)
                .then((response) => {this.subjects = response.data})
                .catch((error) => console.log(error.message));
        },
        deleteSubject(subject){
            console.log('Типа удалил');
        },
    },
    computed:{
        filteredSubjects() {
            if (!this.searchQuery) {
                return this.subjects
            }
            return this.subjects.filter(subjects => subjects.name.toLowerCase().includes(this.searchQuery.toLowerCase()))
        }
    }
}
</script>
<template>
    <Head title="Предметы класса"></Head>
    <AuthenticatedLayout>
        <div v-if="showModal"  style="position: fixed;    z-index: 9999;    top: 0;    left: 0;    width: 100%;    height: 100%;    background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-gray-600 rounded-5" style="position: absolute;    top: 50%;    left: 50%;    transform: translate(-50%, -50%);        border-radius: 5px;    padding: 20px;">
                <div class="float-end">
                    <button class="btn btn-close hover:bg-red-700" @click="showModal = false"></button>
                </div>
                <SubjectAddPage :groupId="groupId"/>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-transparent" >
                <div class="container-fluid">
                    <div class="col-auto">
                        <div class="btn btn-outline-success hover:bg-green-500 rounded-5 float-start">
                            <button @click="showModal = true">Добавить предмет</button>
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
                                <th class="text-center">Учитель</th>
                                <th class="text-center">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="subject in filteredSubjects" :key="subject.id" class="row-auto">
                                <td class="px-3 align-middle">{{ subject.name }}</td>
                                <td class="px-3 align-middle">{{ subject.teacher.user.name }}</td>
                                <td class="px-10 align-middle">
                                    <button class="btn btn-outline-danger hover:text-red-500 border-red-700" @click="deleteSubject(subject)">Удалить</button>
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

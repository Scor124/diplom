<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
</script>
<script>
export default{
    data() {
        return {
            searchQuery: '',
            classes: [],
        };
    },
    mounted() {
        axios.get('/api/classes')
            .then((response) => this.classes = response.data)
            .catch(error => {console.log(error.response.data.message)});
    },
    methods: {

        updateGroup(group) {
            axios.put(`/api/classes/update/${group.id}/`, {
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
                axios.delete(`/api/classes/delete/${group.id}`)
                    .then(response => {
                        axios.get('/api/classes')
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
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-800 rounded-pill" >
                <div class="input-group input-group-sm rounded-5 mx-auto" style="width: 180px;">
                    <input type="text" class="form-control border-0 w-max" placeholder="Поиск по названию группы" v-model="searchQuery">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent border-0"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                    <div class="rounded-pill">
                        <table class="table mx-auto scroll-m-0.5 overscroll-y-auto table-striped table-hover text-gray-300">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Дата создания</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="group in filteredGroups" :key="group.id" class="row-auto">
                                <td class="px-3">{{ group.name }}</td>
                                <td class="px-3">{{ group.formation_date }}</td>
                                <td class="px-10"><button class="btn btn-outline-danger hover:text-red-500 border-red-700" @click="deleteGroup(group)">Удалить</button></td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-outline-secondary hover:text-green-500 hover:border-gray-300 rounded-5 ">
                            <Link :href="route('admin.classes.add')" :ref="route('admin.classes.add')" >
                                Добавить пользователя
                            </Link>
                        </button>
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

export default{
    components: {AuthenticatedLayout},
    data(){
        return{
            name: '',
            formation_date: new Date()
        }
    },
    methods: {
        addUser: function () {
            let group = {
                name: this.name,
                formation_date: this.formation_date
            };

            axios.post('/api/classes/create', group) // change /users to your API endpoint
                .then(function (response) {
                    console.log(response);
                    alert('Group added successfully!');
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
</script>

<template>
    <Head title="Добавление класса"></Head>
    <AuthenticatedLayout>
        <div class="container-fluid text-center">
            <div class="justify-content-center bg-gray-500 rounded">
                <h1>Добавить группу</h1>
                <form class="container-fluid">
                    <fieldset class="col-auto">
                        <label>Название группы:</label>
                        <input class="form-control" type="text" v-model="name">
                    </fieldset>
                    <fieldset class="col-auto">
                        <label>Дата создания:</label>
                        <input class="form-control" type="date" v-model="formation_date">
                    </fieldset>
                    <fieldset class="flex h-4 justify-content-center mt-4">
                        <button class="btn btn-primary col-auto" type="submit" v-on:click.prevent="addUser()">Добавить</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

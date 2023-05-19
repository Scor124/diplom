<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

export default{
    components: {AuthenticatedLayout},
    data(){
        return{
            name: '',
            email: '',
            verified_at: '',
            password: '',
        }
    },
    methods: {
        addUser: function () {
            let user = {
                name: this.name,
                email: this.email,
                verified_at: this.verified_at,
                password: this.password,
                created_at: new Date(),
                updated_at: new Date()
            };

            axios.post('/api/users/create', user) // change /users to your API endpoint
                .then(function (response) {
                    console.log(response);
                    alert('User added successfully!');
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
</script>

<template>
    <Head title="Добавление пользователя"></Head>
    <AuthenticatedLayout>
        <div class="container-fluid text-center">
            <div class="justify-content-center bg-gray-500 rounded">
                <h1>Add User</h1>
                <form class="container-fluid">
                    <fieldset class="col-auto">
                        <label>Name:</label>
                        <input class="form-textarea" type="text" v-model="name">
                    </fieldset>
                    <fieldset class="col-auto">
                        <label>Email:</label>
                        <input class="form-input" type="email" v-model="email">
                    </fieldset>
                    <fieldset class="col-auto">
                        <label>Verification Date:</label>
                        <input type="date" v-model="verified_at">
                    </fieldset>
                    <fieldset class="col-auto">
                        <label>Password:</label>
                        <input class="form-input" type="password" v-model="password">
                    </fieldset>
                    <fieldset class="flex h-4 justify-content-center mt-4">
                        <button class="btn btn-primary col-auto" type="submit" v-on:click.prevent="addUser()">Add User</button>
                    </fieldset>
                </form>
            </div>
        </div>


    </AuthenticatedLayout>
</template>

<style scoped>

</style>

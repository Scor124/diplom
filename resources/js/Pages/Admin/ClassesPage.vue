<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head title="Управление классами"></Head>
    <AuthenticatedLayout>
        <div class="bg-dark border border-dark rounded justify-center">
            <input class="bg-dark text-light border-0" type="text" placeholder="Поиск по Ф.И.О. и e-mail" v-model="searchQuery">
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <table class="table-auto scroll-m-0.5 overscroll-y-auto">
                    <thead>
                    <tr >
                        <th>Ф.И.О.</th>
                        <th>E-mail</th>
                        <th>Подтвержден</th>
                        <th>Учитель</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in filteredUsers" :key="user.id" class="row-auto">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td><input class="justify-center" type="checkbox" v-model="user.is_verified" @change="updateUser(user)"></td>
                        <td><input class="items-center" type="checkbox" v-model="user.is_teacher" @change="updateUser(user)"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

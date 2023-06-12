<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
<script>
import {usePage} from "@inertiajs/vue3";
import axios from "axios";

const user = usePage().props.auth.user;
export default {
    data() {
        return {
            student_id: user.id,
            subjects: [],
        };
    },
    mounted() {
        axios.get(`/classes/${this.student_id}/subjects`)
            .then(response => {
                this.classes = response.data;
            })
            .catch(error => console.log(error.message))
    },
    methods:{
        getMarkForSubject(subject){

        },
    },
};
</script>
<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="container-fluid">

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

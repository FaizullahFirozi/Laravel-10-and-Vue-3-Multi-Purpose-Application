<script setup>
import axios from "axios";
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { useToastr } from "@/toastr";
import { Form, Field, ErrorMessage  } from "vee-validate";
import * as yup from "yup";

const router = useRouter();
const toastr = useToastr();
const form = ref([]);


// const form = reactive({
//     title: '',
//     client_id: '',
//     start_time: '',
//     end_time: '',
//     description: '',
// });

const createAppiontmentSchema = yup.object({
    title: yup.string().required(),
    // ------>
});

const createAppointment = (values, actions) => {
    console.log(form);
    axios
        .post("/api/appointments/create", values)
        .then((response) => {
            router.push("/admin/appointments");
            toastr.success("Appointment Created Successfull");
        })
        .catch((error) => {
            actions.setErrors(error.response.data.errors);
        });
};
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <span v-if="editMode">Edit</span>
                        <span v-else>Create</span>
                        Appointment
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard"
                                >Home</router-link
                            >
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/appointments"
                                >Appointments</router-link
                            >
                        </li>
                        <li class="breadcrumb-item active">
                            <span v-if="editMode">Edit</span>
                            <span v-else>Create</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <Form
                                ref="form"
                                @submit="createAppointment"
                                :validation-schema="createAppiontmentSchema"
                                v-slot:default="{ errors }"
                            >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <Field
                                                name="title"
                                                type="text"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': errors.title,
                                                }"
                                                id="title"
                                                placeholder="Enter Title"
                                            />
                                            <span class="invalid-feedback">{{
                                                errors.title
                                            }}</span>
                                            <ErrorMessage class="invalid-feedback" name="title" />
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client"
                                                >Client Name</label
                                            >
                                            <select
                                                name="client_id"
                                                id="client"
                                                class="form-control"
                                            >
                                                <option value="1">a</option>
                                                <option value="2">b</option>
                                                <option value="3">c</option>
                                            </select>
                                            <span
                                                class="invalid-feedback"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start-time"
                                                >Start Time</label
                                            >
                                            <input
                                                v-model="form.start_time"
                                                type="text"
                                                class="form-control flatpickr"
                                                id="start-time"
                                            />
                                            <span
                                                class="invalid-feedback"
                                            ></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end-time"
                                                >End Time</label
                                            >
                                            <input
                                                v-model="form.end_time"
                                                type="text"
                                                class="form-control flatpickr"
                                                id="end-time"
                                            />
                                            <span
                                                class="invalid-feedback"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                        v-model="form.description"
                                        name="description"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.description,
                                        }"
                                        id="description"
                                        rows="3"
                                        placeholder="Enter Description"
                                    ></textarea>
                                    <span class="invalid-feedback">{{
                                        errors.description
                                    }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <Form @submit="handleSubmit" v-slot:default="{ errors }">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input v-model="form.title" type="text" class="form-control" :class="{ 'is-invalid': errors.title }" id="title" placeholder="Enter Title">
                                            <span class="invalid-feedback">{{ errors.title }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Client Name</label>
                                            <select v-model="form.client_id" id="client" class="form-control" :class="{ 'is-invalid': errors.client_id }">
                                                <option v-for="client in clients" :value="client.id" :key="client.id">{{ client.first_name }} {{ client.last_name }}</option>
                                            </select>
                                            <span class="invalid-feedback">{{ errors.client_id }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start-time">Start Time</label>
                                            <input v-model="form.start_time" type="text" class="form-control flatpickr" :class="{'is-invalid': errors.start_time}" id="start-time">
                                            <span class="invalid-feedback">{{ errors.start_time }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end-time">End Time</label>
                                            <input v-model="form.end_time" type="text" class="form-control flatpickr" :class="{'is-invalid': errors.end_time}" id="end-time">
                                            <span class="invalid-feedback">{{ errors.end_time }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="form.description" class="form-control" :class="{'is-invalid': errors.description}" id="description" rows="3"
                                        placeholder="Enter Description"></textarea>
                                    <span class="invalid-feedback">{{ errors.description }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</template>

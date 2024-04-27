<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { Form, Field } from "vee-validate";
import * as yup from "yup";
import { useToastr } from "@/toastr";

const toastr = useToastr();
const users = ref([]);
const editing = ref(false);
const formValues = ref();
const form = ref(null);
const userIdBeingDeleted = ref(null);

const getUsers = () => {
    axios.get("/api/users").then((response) => {
        users.value = response.data;
    });
};

const createUserSchema = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().required().min(5),
});

const editUserSchema = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    // password: yup.string().when((password, schema) => {
    //     return password ? schema.required().min(3) : schema;
    // }),
});

const createUser = (values, { resetForm }) => {
    
    axios.post("/api/users", values).then((response) => {
        users.value.unshift(response.data);

        $("#userFormModal").modal("hide");

        resetForm();
    });
    toastr.success("کارمند اضافه شو");
};

const addUser = () => {
    editing.value = false;
    
    form.value.resetForm();

    $("#userFormModal").modal("show");
};

const editUser = (user) => {
    editing.value = true;

    form.value.resetForm();

    $("#userFormModal").modal("show");

  
    // Use setValues method to set form values
    form.value.setValues({
        name: user.name,
        email: user.email,
        // password: "admin", // Assuming you want to keep the password empty when editing
    });
};

const updateUser = (values) => {
    console.log(values);
    axios
        .put("/api/users/" + values.id, values)
        .then((response) => {
            const index = users.value.findIndex(
                (user) => user.id === response.data.id
            );
            users.value[index] = response.data;
            $("#userFormModal").modal("hide");
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            form.value.resetForm();
        });
};

// const handleSubmit = (values) => {

//     if (editing.value) {
//         updateUser(values);
//     } else {
//         createUser(values);
//     }
// };

const confirmUserDeletion = (user) => {
    userIdBeingDeleted.value = user.id;
    $("#deleteUserModal").modal("show");
};

const deleteUser = () => {
    axios.delete(`/api/users/${userIdBeingDeleted.value}`).then(() => {
        $("#deleteUserModal").modal("hide");
        users.value = users.value.filter(
            (user) => user.id !== userIdBeingDeleted.value
        );
        toastr.success("User Deleted Successfully");
    });
};

onMounted(() => {
    getUsers();
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ListUsers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">ListUsers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <button @click="addUser" type="button" class="mb-2 btn btn-primary">
                <i class="fa fa-plus-circle mr-1"></i>
                Add New User
            </button>
            <p>Total Users: {{ users.length }}</p>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Role</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="users.length > 0">
                            <tr v-for="(user, index) in users" :key="user.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <a href="#" @click.prevent="editUser(user)"
                                        ><i class="fa fa-edit"></i
                                    ></a>
                                    <a
                                        href="#"
                                        @click.prevent="
                                            confirmUserDeletion(user)
                                        "
                                        ><i
                                            class="fa fa-trash text-danger ml-3"
                                        ></i
                                    ></a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="6" align="center">
                                    No Categories Found. معلومات پیدا نه شول
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- The Create & Edit Modal -->
    <div
        class="modal fade"
        id="userFormModal"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        <span v-if="editing">Edit User</span>
                        <span v-else>Add New User</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <!-- Modal body -->
                <Form
                    ref="form"
                    @submit="editing ? updateUser : createUser"
                    :validation-schema="
                        editing ? editUserSchema : createUserSchema
                    "
                    v-slot="{ errors }"
                    :initial-values="formValues"
                >
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name:</label>
                            <Field
                                name="name"
                                id="name"
                                type="name"
                                class="form-control"
                                :class="{ 'is-invalid': errors.name }"
                                placeholder="Enter name"
                                aria-describedby="nameHelp"
                            />
                            <span class="invalid-feedback">{{
                                errors.name
                            }}</span>
                        </div>
                        <Field name="id" />
                        <div class="form-group">
                            <label>Email:</label>
                            <Field
                                name="email"
                                type="email"
                                class="form-control"
                                :class="{ 'is-invalid': errors.email }"
                                placeholder="Enter email"
                                aria-describedby="nameHelp"
                            />
                            <span class="invalid-feedback">{{
                                errors.email
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <Field
                                name="password"
                                type="password"
                                class="form-control"
                                :class="{ 'is-invalid': errors.password }"
                                placeholder="Enter password"
                                aria-describedby="nameHelp"
                            />
                            <span class="invalid-feedback">{{
                                errors.password
                            }}</span>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>

                        <button
                            type="button"
                            class="btn btn-danger"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>

    <!-- The Delete Modal -->
    <div
        class="modal fade"
        id="deleteUserModal"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h6 class="modal-title">
                        Are you Sure want to Delete User ?
                    </h6>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button
                        @click.prevent="deleteUser"
                        type="submit"
                        class="btn btn-danger"
                    >
                        Yes
                    </button>

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        No
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

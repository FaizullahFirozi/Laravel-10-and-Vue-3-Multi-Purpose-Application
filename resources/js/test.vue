<template>
    <div class="content">
        <div class="container-fluid">
            <h1>This is Test Section</h1>

            <div class="card">
                <div class="card-body">
                    <form @submit="createAppointment" :validation-schema="schema">
                        <label>First Name</label>
                        <input v-model="form.first_name"
                            type="text"
                            name="first_name"
                            class="form-control"
                            placeholder="First Name"
                        />
                        <ErrorMessage name="first_name"/>
                        <ErrorMessage class="invalid-feedback" name="title" />

                        <label>Last Name</label>
                        <input v-model="form.last_name"
                            type="text"
                            name="last_name"
                            class="form-control"
                            placeholder="Last Name"
                        />
                        <input type="submit" value="Save" class="btn btn-success mt-3">
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ErrorMessage } from "vee-validate";
import * as yup from "yup";

const schema = yup.object({
    first_name: yup.string().required(),
    last_name: yup.string().required().min(9),
})


export default {

    data() {
        return{
              form: {
                first_name: '',
                last_name: '',
              }
        }
    },

    methods: {
        saveData(){

          
        }, 
        createAppointment(){
            
        }
    }

}

</script>

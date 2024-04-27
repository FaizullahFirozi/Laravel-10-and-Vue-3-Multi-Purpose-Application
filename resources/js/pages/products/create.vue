<template>
     <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item"><router-link to="/admin/products">Products</router-link></li>
                         <li class="breadcrumb-item active">Create</li>
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
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Product Name</label>
                                            <input type="text" class="form-control" id="title" placeholder="Enter Title">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Price</label>
                                            <input type="text" class="form-control" id="title" placeholder="Enter Product Price">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" rows="3"
                                        placeholder="Enter Description"></textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1>Hello {{ myData }}</h1>
    <!-- <h1>Hello {{ products() }}</h1> -->


</template>


<script>
import axios from 'axios';



export default {

    data() {
        return {
            myData: null,
        };
    },

    mounted() {
        this.fetchData;
    },

    methods: {
            fetchData() {
                var url = '/api/products'
                axios.get(url)
                .then(res => {
                    this.myData = res.data;
                })
                .catch(error => {
                    console.error('Error fetching data', error);
                });
            }
    }
};

</script>
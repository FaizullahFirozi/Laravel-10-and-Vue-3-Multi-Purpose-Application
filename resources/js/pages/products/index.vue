<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard"
                                >Home</router-link
                            >
                        </li>
                        <li class="breadcrumb-item active">ListUsers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- <router-link to="/admin/products/create" class="mb-2 btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add Product</router-link> -->
            <router-link
                :to="{ name: 'admin.product.create' }"
                class="mb-2 btn btn-primary"
            >
                <i class="fa fa-plus-circle mr-1"></i> Add Product</router-link
            >
            <p>
                Total Products:
                <span>{{ products.length }}</span>
            </p>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="products.length > 0">
                            <tr
                                v-for="(product, index) in products"
                                :key="product.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.price }}</td>
                                <td>
                                    <router-link :to="{name: 'admin.product.edit', params:{id:product.id}}"
                                        >Edit</router-link
                                    >
                                    <a
                                        href="#"
                                        @click="deleteProduct(product.id)"
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
                                    No Products Found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "admin.product",
    data() {
        return {
            products: {},
        };
    },

    // created() {
    //     this.getProducts();
    // },
    mounted() {
        this.getProducts();
    },

    methods: {
        getProducts() {
            axios
                .get("/api/products")
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching data", error);
                });
        },

        deleteProduct(productId) {
            axios
                .delete(`/api/products/${productId}`)
                .then((response) => {
                    console.log("data deleted", response);
                })
                .catch((error) => {
                    console.log('Error Deleting data ', error)
                });
        },
    },
};
</script>

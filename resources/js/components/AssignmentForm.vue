<template>
    <form @submit.prevent="handleSubmit" class="form-horizontal">
        <div
            v-if="server_message !== false"
            class="alert alert-danger"
            role="alert"
        >
            {{ this.server_message }}
            <a v-if="try_logging_in" href="/login">Login</a>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Name" :errors="form_errors.name">
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        v-model="form_data.name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Client Id"
                    :errors="form_errors.client_id"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="client_id"
                        v-model="form_data.client_id"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="User Id" :errors="form_errors.user_id">
                    <input
                        type="text"
                        class="form-control"
                        name="user_id"
                        v-model="form_data.user_id"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Deleted At"
                    :errors="form_errors.deleted_at"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="deleted_at"
                        v-model="form_data.deleted_at"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="form-group mt-4">
            <div class="row">
                <div class="col-md-6">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        :disabled="processing"
                    >
                        <span v-if="this.form_data.id">Change</span>
                        <span v-else="this.form_data.id">Add</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/assignment" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";

export default {
    name: "assignment-form",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        },
        csrf_token: {
            type: String,
            default: ""
        }
    },
    data() {
        return {
            form_data: {
                // _method: 'patch',
                _token: this.csrf_token,
                id: 0,
                name: "",
                client_id: 0,
                user_id: 0,
                deleted_at: ""
            },
            form_errors: {
                id: false,
                name: false,
                client_id: false,
                user_id: false,
                deleted_at: false
            },
            server_message: false,
            try_logging_in: false,
            processing: false
        };
    },
    mounted() {
        if (this.record !== false) {
            // this.form_data._method = 'patch';
            Object.keys(this.record).forEach(
                i => (this.form_data[i] = this.record[i])
            );
        } else {
            // this.form_data._method = 'post';
        }
    },
    methods: {
        async handleSubmit() {
            this.server_message = false;
            this.processing = true;
            let url = "";
            let amethod = "";
            if (this.form_data.id) {
                url = "/assignment/" + this.form_data.id;
                amethod = "put";
            } else {
                url = "/assignment";
                amethod = "post";
            }
            await axios({
                method: amethod,
                url: url,
                data: this.form_data
            })
                .then(res => {
                    if (res.status === 200) {
                        window.location = "/assignment";
                    } else {
                        this.server_message = res.status;
                    }
                })
                .catch(error => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            // Clear errors out
                            Object.keys(this.form_errors).forEach(
                                i => (this.form_errors[i] = false)
                            );
                            // Set current errors
                            Object.keys(error.response.data.errors).forEach(
                                i =>
                                    (this.form_errors[i] =
                                        error.response.data.errors[i])
                            );
                        } else if (error.response.status === 404) {
                            // Record not found
                            this.server_message = "Record not found";
                            window.location = "/assignment";
                        } else if (error.response.status === 419) {
                            // Unknown status
                            this.server_message =
                                "Unknown Status, please try to ";
                            this.try_logging_in = true;
                        } else if (error.response.status === 500) {
                            // Unknown status
                            this.server_message =
                                "Server Error, please try to ";
                            this.try_logging_in = true;
                        } else {
                            this.server_message = error.response.data.message;
                        }
                    } else {
                        console.log(error.response);
                        this.server_message = error;
                    }
                    this.processing = false;
                });
        }
    }
};
</script>

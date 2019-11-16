<template>
    <div
        class="tab-pane fade show mt-2"
        id="unitRequests"
        role="tabpanel"
        aria-labelledby="unitRequests-tab"
    >
        <table class="table table-responsive-md">
            <thead class="thead-light">
                <tr>
                    <th
                        scope="col"
                        v-for="(column, index) in columns"
                        :key="index"
                    >
                        {{ column }}
                    </th>
                </tr>
            </thead>
            <td v-if="isLoading" class="text-center" colspan="3">
                <app-spinner></app-spinner>
            </td>
            <td
                v-else-if="unitRequests.length <= 0"
                class="text-center"
                colspan="4"
            >
                No Units Requested.
                <router-link to="/requests" tag="a"
                    >Request a unit here</router-link
                >.
            </td>
            <tbody v-else>
                <tr v-for="unitReq in unitRequests" :key="unitReq.id">
                    <th scope="row">{{ unitReq.unit_name }}</th>
                    <td>
                        <span v-if="unitReq.trial_name">{{
                            unitReq.trial_name
                        }}</span>
                    </td>
                    <td>
                        {{ 48 - parseInt(unitReq.difference) }} Hr<span
                            v-if="parseInt(unitReq.difference) !== 47"
                            >s</span
                        >
                    </td>
                    <td>
                        <button
                            @click="deleteRequest(unitReq.id)"
                            class="btn btn-link text-danger p-0 m-0 pb-1"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    props: ["isLoading", "unitRequests"],
    data() {
        return {
            columns: ["Unit Requested", "Trial Name", "Expires In", "Actions"]
        };
    },
    methods: {
        deleteRequest(id) {
            Swal.fire({
                title: "Deleting Request",
                text: "Are you sure you want to delete this request?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("./api/unit_requests/" + id)
                        .then(res => {
                            Swal.fire(
                                "Deleting Request",
                                "Request Deleted Successfully",
                                "success"
                            );
                            this.$parent.reloadRequests();
                        })
                        .catch(err => {
                            Swal.fire(
                                "Error Deleting Request",
                                "Request could not be deleted, please try again later!",
                                "error"
                            );
                        });
                }
            });
        }
    }
};
</script>

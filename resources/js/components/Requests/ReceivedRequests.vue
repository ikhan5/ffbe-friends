<template>
  <div
    class="tab-pane fade show mt-2"
    id="receivedRequests"
    role="tabpanel"
    aria-labelledby="receivedRequests-tab"
  >
    <table class="table table-responsive-md">
      <thead class="thead-light">
        <tr>
          <th scope="col" v-for="(column, index) in columns" :key="index">{{column}}</th>
        </tr>
      </thead>
      <td v-if="isLoading" class="text-center" colspan="7">
        <app-spinner></app-spinner>
      </td>
      <tbody v-else>
        <tr v-for="notification in notifications" :key="notification.id">
          <template v-if="notification.received">
            <th scope="row">{{notification.profile.ign}}</th>
            <td>{{notification.profile.friendCode | friendCode}}</td>
            <td>
              <button
                @click="updateStatus(notification.id)"
                class="btn btn-link text-primary p-0 m-0 pb-1"
              >Added</button>
              <button
                @click="deleteStatus(notification.id)"
                class="btn btn-link text-danger p-0 m-0 pb-1"
              >
               Delete
              </button>
            </td>
          </template>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
export default {
  props: ["notifications", "isLoading"],
  data() {
    return {
      columns: ["User Name", "Friend Code", "Actions"]
    };
  },
  methods: {
    updateStatus(id) {
      axios
        .put(`/api/notifications/${id}`, {
          status: 'added'
        })
        .then(res => {
          Swal.fire(
            "Status Update",
            "Notification has been updated successfully!",
            "success"
          );
        })
        .catch(err => {
          Swal.fire(
            "Status Error",
            "Notification could not be updated, please try again later!",
            "error"
          );
          console.log(err.response);
        });
    },
    deleteStatus(id) {
      axios
        .delete("/api/notifications/" + id)
        .then(res => {
          Swal.fire(
            "Status Update",
            "Notification has been deleted!",
            "success"
          );
        })
        .catch(err => {
          Swal.fire(
            "Status Error",
            "Notification could not be deleted, please try again later!",
            "error"
          );
          console.log(err.response);
        });
    }
  }
};
</script>
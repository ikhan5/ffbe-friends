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
          <th scope="col">Actions</th>
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
            <td v-if="notification.status === 'default'">
              <select class="form-control" v-model="status" @change="updateStatus(notification.id)">
                <option disabled value="default">--Status--</option>
                <option value="added">Added</option>
                <option value="remove">Remove</option>
              </select>
            </td>
            <template v-else>
              <td>{{notification.status | capitalize }}</td>
              <td>
                <button
                  @click="deleteStatus(notification.id)"
                  class="btn btn-lg btn-link text-danger p-0 m-0 pb-1 ml-4"
                >
                  <i class="fas fa-times"></i>
                </button>
              </td>
            </template>
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
      columns: ["User Name", "Friend Code", "Status"],
      status: "default"
    };
  },
  methods: {
    updateStatus(id) {
      axios
        .put(`/api/notifications/${id}`, {
          status: this.status
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
          this.getNotifications();
        })
        .catch(err => {
          Swal.fire(
            "Status Error",
            "Notification could not be deleted, please try again later!",
            "error"
          );
          console.log(err.response);
        });
    },
    getNotifications() {
      axios
        .get("/api/notifications")
        .then(res => {
          this.notifications = res.data;
          this.notifLoading = false;
        })
        .catch(err => {
          Swal.fire(
            "Error, Kupo!",
            "There was an error whilst loading the requests, please try again later",
            "error"
          );
        });
    }
  }
};
</script>
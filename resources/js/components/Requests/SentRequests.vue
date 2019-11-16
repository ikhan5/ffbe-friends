<template>
  <div
    class="tab-pane fade show mt-2"
    id="sentRequests"
    role="tabpanel"
    aria-labelledby="sentRequests-tab"
  >
    <table class="table table-responsive-md">
      <thead class="thead-light">
        <tr>
          <th scope="col" v-for="(column, index) in columns" :key="index">{{column}}</th>
        </tr>
      </thead>
      <td v-if="isLoading" class="text-center" colspan="3">
        <app-spinner></app-spinner>
      </td>
      <tbody v-else>
          <tr v-for="notification in notifications" :key="notification.id">
            <template v-if="!notification.received">
              <th scope="row">{{notification.profile.ign}}</th>
              <td>{{notification.profile.friendCode | friendCode}}</td>
              <td v-if="notification.status === 'added'">{{notification.status | capitalize}}</td>
              <td v-else>Pending</td>
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
    };
  },
};
</script>
<template>
  <layout-div>
    <div class="row justify-content-md-center">
      <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <div class="d-flex">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a @click="logoutAction()" class="nav-link " aria-current="page" href="#">Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <h2 class="text-center mt-5">Welcome, {{ user?.username }}!</h2>
        <router-link to="/create/order" class="btn btn-primary btn-block">Create Order</router-link>
      </div>
      <table class="styled-table">
        <thead>
        <tr>
          <th>ID</th>
          <th>Detail</th>
          <th>Status</th>
          <th>UserID</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody v-if="orders.length">
        <tr v-for="(order, index) in orders" :key="index">
          <td>{{ order.ID }}</td>
          <td>{{ order.detail }}</td>
          <td>{{ order.status }}</td>
          <td>{{ order.user_id }}</td>
          <td>
            <!-- Buttons for delete and update -->
            <button @click="deleteOrder(order.ID)" class="btn btn-danger">Delete</button>
            <button @click="redirectToUpdate(order.ID)" class="btn btn-primary">Update</button>
          </td>
        </tr>
        </tbody>
        <div v-else>
          <p>No orders available.</p>
        </div>
      </table>
    </div>
  </layout-div>
</template>

<script>
import axios from 'axios';
import LayoutDiv from '../LayoutDiv.vue';

export default {
  name: 'DashboardPage',
  components: {
    LayoutDiv,
  },
  data() {
    return {
      user: {},
      orders: [], // Initialize orders as an empty array
    };
  },
  created() {
    this.getUser();
    this.getOrders();
    if (localStorage.getItem('token') == "" || localStorage.getItem('token') == null) {
      this.$router.push('/');
    }

  },
  methods: {
    getUser() {
      axios.post('/user', {token: localStorage.getItem('token')})
          .then((response) => {
            this.user = response.data;
          })
          .catch((error) => {
            console.error('Error fetching user:', error);
          });
    },

    getOrders() {
      axios.post('/orders', {token: localStorage.getItem('token')})
          .then((response) => {
            if (response.data === 'No orders found[]') {
              this.orders = [];
            } else {
              this.orders = response.data;
            }
          })
          .catch((error) => {
            console.error('Error fetching orders:', error);
          });
    },

    deleteOrder(orderId) {
      axios.post('/order/delete', {order_id: orderId})
          .then((response) => {
            this.getOrders();
            console.log('Order deleted successfully');
          })
          .catch((error) => {
            console.error('Error deleting order:', error);
          });
    },
    redirectToUpdate(orderId) {
      this.$router.push(`/update/order/${orderId}`);
    },

    logoutAction() {
      this.$router.push('/');
      localStorage.setItem('token', "");
      axios.post('/logout', {}, {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}})
          .then((response) => {
            // Handle logout response if needed
          })
          .catch((error) => {
            console.error('Error logging out:', error);
          });
    }
  },
};
</script>

<style>
.styled-table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin: 1em 0;
}

.styled-table th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
  padding: 10px;
  text-align: left;
}

.styled-table td {
  border-bottom: 1px solid #ddd;
  padding: 10px;
}

.styled-table tr:hover {
  background-color: #f5f5f5;
}
</style>

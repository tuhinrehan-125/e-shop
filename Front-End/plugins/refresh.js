const strategy = "local";
const FALLBACK_INTERVAL = 900 * 1000 * 0.75;

// async function refreshTokenF($auth, $axios, refreshToken) {
//   try {
//     const response = await $axios.post('auth/refresh')
//     let token = 'Bearer ' + response.data.refresh_token
//     console.log(refreshToken);
//     console.log(token);
//     $auth.setToken(strategy, token)
//     $axios.setToken(token)
//     return decodeToken.call(this, token).exp
//   } catch (error) {
//     $auth.logout()
//     throw new Error('Error while refreshing token')
//   }
// }

export default async function({ app }) {
  const { $axios, $auth } = app;

  $axios.interceptors.response.use(
    function(response) {
      if (response.headers.Authorization !== undefined) {
        let token = response.headers.Authorization;
        $auth.setToken(strategy, token);
        $auth.strategy._setToken(token);
        $axios.setToken(token);
        return $auth.fetchUser();
      }
      return response;
    },
    error => {
      if (error.response.status === 401) {
        app.$auth.$state.loggedIn=false
        app.$auth.$state.user=false
        app.router.push("/");
        let data = { alert: true, message: "Session Time out, Please Login",type:'error' };
        app.store.commit("SET_ALERT", data);
        return Promise.reject(error);
      }
    }
  );
}

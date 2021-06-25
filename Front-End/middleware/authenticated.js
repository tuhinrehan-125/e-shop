export default function ({ store, redirect }) {
  if(store.state.user && store.state.auth.user.data.user_business_location.length==0)
  {
    return redirect('/business-setting-and-location')
  }

}


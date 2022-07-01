export default async function authGuard(
  to: object,
  from: object,
  next: any
) {

  const tokenString = await localStorage.getItem('token') ?? ''
  const token = JSON.parse(tokenString);
  const { expires_at } = token ?? null; // UNIX Timestamp

  const expired = (expires_at * 1000) > Date.now() // UNIX Timestamp -> Millisec (*1000)

  if(expired) {
    next(); 
  } else if (to.name !== 'login') {
    next('/login');
  } else {
    next();
  }
}
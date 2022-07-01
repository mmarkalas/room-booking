export default function authHeader() {
  const tokenString = localStorage.getItem('token') ?? '';

  const token = JSON.parse(tokenString);

  if (token && token.expires_at < Date.now()) {
    return [['Authorization', 'Bearer ' + token.access_token]];
  } else {
    return [[]];
  }
}
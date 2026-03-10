import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import axios from 'axios'
import api from '../api'

function Login() {
  const navigate = useNavigate()
  const [formData, setFormData] = useState({
    email: '',
    password: '',
    grant_type: 'password',
    client_id: import.meta.env.VITE_SECRET_ID,
    client_secret: import.meta.env.VITE_SECRET_KEY
  })
  const [error, setError] = useState('')
  const [loading, setLoading] = useState(false)

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    setLoading(true)
    setError('')

    try {
      const loginData = {
        grant_type: formData.grant_type,
        client_id: formData.client_id,
        client_secret: formData.client_secret,
        username: formData.email,
        password: formData.password,
      }
      const response = await axios.post(`${import.meta.env.VITE_API_BASE_URL}/oauth/token`, loginData)
      const { access_token } = response.data
      localStorage.setItem('token', access_token)
      navigate('/dashboard')
    } catch (err) {
      setError(err.response?.data?.message || 'Connexion échouée')
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="min-h-screen bg-base-200 flex items-center justify-center px-4">
      <div className="card w-full max-w-md bg-base-100 shadow-xl">
        <div className="card-body">
          <h2 className="card-title text-2xl font-bold justify-center mb-2">
            Connectez-vous à votre compte
          </h2>
          <p className="text-center text-base-content/60 mb-6">
            Connectez-vous pour gérer vos événements et invités
          </p>

          <form onSubmit={handleSubmit}>
            {error && (
              <div className="alert alert-error mb-4">
                <span>{error}</span>
              </div>
            )}
            <div className="form-control mb-4">
              <label className="label">
                <span className="label-text font-medium">Email</span>
              </label>
              <input
                type="email"
                name="email"
                placeholder="vous@example.com"
                className="input input-bordered w-full"
                value={formData.email}
                onChange={handleChange}
                required
              />
            </div>

            <div className="form-control mb-6">
              <label className="label">
                <span className="label-text font-medium">Mot de passe</span>
              </label>
              <input
                type="password"
                name="password"
                placeholder="Entrez votre mot de passe"
                className="input input-bordered w-full"
                value={formData.password}
                onChange={handleChange}
                required
              />
            </div>

            <button type="submit" className="btn btn-primary w-full" disabled={loading}>
              {loading ? 'Connexion en cours...' : 'Connexion'}
            </button>
          </form>

          <div className="divider">Ou</div>

          <p className="text-center text-sm">
            {"Pas de compte? "}
            <Link to="/register" className="link link-primary font-medium">
              Inscrivez vous
            </Link>
          </p>
        </div>
      </div>
    </div>
  )
}

export default Login

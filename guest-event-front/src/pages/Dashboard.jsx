import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import api from '../api'

function Dashboard() {
  const [events, setEvents] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')

  useEffect(() => {
    const fetchEvents = async () => {
      try {
        const response = await api.get('/events')
        setEvents(response.data.data || response.data)
      } catch (err) {
        setError('Failed to load events')
      } finally {
        setLoading(false)
      }
    }

    fetchEvents()
  }, [])

  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('en-US', options)
  }

  return (
    <div>
      <div className="flex items-center justify-between mb-8">
        <h1 className="text-3xl font-bold">Mes Événements</h1>
        <Link to="/events/create" className="btn btn-primary">
          Créer un événement
        </Link>
      </div>

      {error && (
        <div className="alert alert-error mb-4">
          <span>{error}</span>
        </div>
      )}

      <div className="card bg-base-100 shadow-xl">
        <div className="card-body p-0">
          <div className="overflow-x-auto">
            <table className="table table-zebra">
              <thead>
                <tr>
                  <th>Titre</th>
                  <th>Lieu</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                {loading ? (
                  <tr>
                    <td colSpan="4" className="text-center py-8">
                      <span className="loading loading-spinner loading-lg"></span>
                    </td>
                  </tr>
                ) : (
                  events.map((event) => (
                    <tr key={event.id}>
                      <td className="font-medium">{event.title}</td>
                      <td className="text-base-content/70">{event.location}</td>
                      <td className="text-base-content/70">
                        {formatDate(event.start_time)}
                      </td>
                      <td>
                        <Link
                          to={`/events/${event.id}`}
                          className="btn btn-ghost btn-sm"
                        >
                          Voir
                        </Link>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>

          {!loading && events.length === 0 && (
            <div className="text-center py-12">
              <p className="text-base-content/60">Aucun événement pour le moment</p>
              <Link
                to="/events/create"
                className="btn btn-primary btn-sm mt-4"
              >
                Créez votre premier événement
              </Link>
            </div>
          )}
        </div>
      </div>
    </div>
  )
}

export default Dashboard

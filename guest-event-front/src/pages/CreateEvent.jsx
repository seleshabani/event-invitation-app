import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import api from '../api'

function CreateEvent() {
  const navigate = useNavigate()
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    location: '',
    date: '',
    time: '',
  })
  const [file, setFile] = useState(null)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState('')

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    })
  }

  const handleFileChange = (e) => {
    setFile(e.target.files[0])
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    setLoading(true)
    setError('')

    try {
      const eventData = {
        title: formData.title,
        description: formData.description,
        location: formData.location,
        start_time: formData.date,
        end_time: formData.end_date,
      }

      const response = await api.post('/events', eventData)
      const event = response.data.data || response.data

      
      if (file) {
        const formDataUpload = new FormData()
        formDataUpload.append('file', file)
        formDataUpload.append('event_id', event.id)
        await api.post('/guests/upload', formDataUpload, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
      }

      navigate('/dashboard')
    } catch (err) {
      setError(err.response?.data?.message || 'Echec de la création de l\'événement')
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="max-w-2xl mx-auto">
      <h1 className="text-3xl font-bold mb-8">Créer un événement</h1>

      <div className="card bg-base-100 shadow-xl">
        <div className="card-body">
          <form onSubmit={handleSubmit}>
            {error && (
              <div className="alert alert-error mb-4">
                <span>{error}</span>
              </div>
            )}
            <div className="form-control mb-4">
              <label className="label">
                <span className="label-text font-medium">Titre de l'événement</span>
              </label>
              <input
                type="text"
                name="title"
                placeholder="Entrez le titre de l'événement"
                className="input input-bordered w-full"
                value={formData.title}
                onChange={handleChange}
                required
              />
            </div>

            <div className="form-control mb-4">
              <label className="label">
                <span className="label-text font-medium">Description</span>
              </label>
              <textarea
                name="description"
                placeholder="Décrivez votre événement"
                className="textarea textarea-bordered w-full h-32"
                value={formData.description}
                onChange={handleChange}
                required
              />
            </div>

            <div className="form-control mb-4">
              <label className="label">
                <span className="label-text font-medium">Lieu</span>
              </label>
              <input
                type="text"
                name="location"
                placeholder="Lieu de l'événement"
                className="input input-bordered w-full"
                value={formData.location}
                onChange={handleChange}
                required
              />
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div className="form-control">
                <label className="label">
                  <span className="label-text font-medium">Date</span>
                </label>
                <input
                  type="datetime-local"
                  name="date"
                  className="input input-bordered w-full"
                  value={formData.date}
                  onChange={handleChange}
                  required
                />
              </div>

              <div className="form-control">
                <label className="label">
                  <span className="label-text font-medium">Date de fin</span>
                </label>
                <input
                  type="datetime-local"
                  name="end_date"
                  className="input input-bordered w-full"
                  value={formData.end_date}
                  onChange={handleChange}
                  required
                />
              </div>
            </div>

            <div className="form-control mb-6">
              <label className="label">
                <span className="label-text font-medium">
                  Guest List (Excel File)
                </span>
              </label>
              <input
                type="file"
                accept=".xlsx,.xls"
                className="file-input file-input-bordered w-full"
                onChange={handleFileChange}
              />
              <label className="label">
                <span className="label-text-alt text-base-content/60">
                  The Excel file must contain two columns: Name and Email
                </span>
              </label>
              {file && (
                <div className="alert alert-info mt-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    className="stroke-current shrink-0 w-6 h-6"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  <span>File selected: {file.name}</span>
                </div>
              )}
            </div>

            <div className="flex gap-4">
              <button
                type="button"
                className="btn btn-ghost flex-1"
                onClick={() => navigate('/dashboard')}
                disabled={loading}
              >
                Cancel
              </button>
              <button type="submit" className="btn btn-primary flex-1" disabled={loading}>
                {loading ? 'Creating...' : 'Create Event'}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  )
}

export default CreateEvent

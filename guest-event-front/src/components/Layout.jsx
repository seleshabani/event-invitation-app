import { Outlet, Link, useNavigate } from 'react-router-dom'

function Layout() {
  const navigate = useNavigate()

  const handleLogout = () => {
    localStorage.removeItem('token')
    navigate('/login')
  }

  return (
    <div className="min-h-screen bg-base-200">
      <div className="navbar bg-base-100 shadow-sm px-6">
        <div className="flex-1">
          <Link to="/dashboard" className="text-xl font-bold text-primary">
            EventFlow
          </Link>
        </div>
        <div className="flex-none gap-4">
          <Link to="/dashboard" className="btn btn-ghost btn-sm">
            Dashboard
          </Link>
          <button onClick={handleLogout} className="btn btn-ghost btn-sm">
            Logout
          </button>
        </div>
      </div>
      <main className="container mx-auto px-6 py-8 max-w-6xl">
        <Outlet />
      </main>
    </div>
  )
}

export default Layout

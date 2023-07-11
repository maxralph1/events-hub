import { useState, useMemo, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { useLocalStorage } from 'react-use-storage'
import { route } from '@/routes'
 
export function useAuth() {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [accessToken, setAccessToken, removeAccessToken] = useLocalStorage('access_token', '')
    const [role, setRole, removeRole] = useLocalStorage('role', '')
    
    const navigate = useNavigate()
    
    const isAuthenticated = useMemo(() => !!accessToken, [accessToken])
    const isSuperAdmin = useMemo(() => (role == '01h3rdp0kj9h454x089d5qr9kg'), [role])
    const isAdmin = useMemo(() => (role == '01h3rdp0kp29pxw78keq5eea92'), [role])
    const isGenericUser = useMemo(() => (role == '01h3rdp0ksan06zb77prancj53'), [role])
    
    useEffect(() => {
        if (accessToken) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`
        }
    }, [accessToken])
    
    async function register(data) {
        setErrors({})
        setLoading(true)
    
        return axios.post('register', data)
        .then((response) => {
            setAccessToken(response.data.access_token)
            setRole(response.data.role_id)
            navigate(route('dashboard'))
        })
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function login(data) {
        setErrors({})
        setLoading(true)
    
        return axios.post('login', data)
        .then(response => {
            setAccessToken(response.data.access_token)
            setRole(response.data.role_id)
            navigate(route('dashboard'))
        })
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function logout(force = false) {
        if (!force) {
        await axios.post('logout')
        }
    
        removeAccessToken()
        removeRole()
        navigate(route('login'))
    }
    
    return { register, login, errors, loading, isAuthenticated, isSuperAdmin, isAdmin, isGenericUser, logout }
}
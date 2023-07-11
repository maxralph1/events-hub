import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useUser(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getUser(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createUser(user) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/users', user)
        .then(() => navigate(route('users.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getUser(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/users/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateUser(user) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/users/${user.id}`, user)
        .then(() => navigate(route('users.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyUser(user) {
        return axios.delete(`super-admin/users/${user.id}`)
    }
    
    return {
        user: { data, setData, errors, loading },
        createUser,
        updateUser,
        destroyUser,
    }
}
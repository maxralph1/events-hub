import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useNewsletter(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getNewsletter(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createNewsletter(newsletter) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/newsletters', newsletter)
        .then(() => navigate(route('newsletters.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getNewsletter(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/newsletters/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateNewsletter(newsletter) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/newsletters/${newsletter.id}`, newsletter)
        .then(() => navigate(route('newsletters.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyNewsletter(newsletter) {
        return axios.delete(`super-admin/newsletters/${newsletter.id}`)
    }
    
    return {
        newsletter: { data, setData, errors, loading },
        createNewsletter,
        updateNewsletter,
        destroyNewsletter,
    }
}
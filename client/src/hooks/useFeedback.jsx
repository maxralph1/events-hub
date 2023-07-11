import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useFeedback(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getFeedback(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createFeedback(feedback) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/feedbacks', feedback)
        .then(() => navigate(route('feedbacks.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getFeedback(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/feedbacks/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateFeedback(feedback) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/feedbacks/${feedback.id}`, feedback)
        .then(() => navigate(route('feedbacks.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyFeedback(feedback) {
        return axios.delete(`super-admin/feedbacks/${feedback.id}`)
    }
    
    return {
        feedback: { data, setData, errors, loading },
        createFeedback,
        updateFeedback,
        destroyFeedback,
    }
}
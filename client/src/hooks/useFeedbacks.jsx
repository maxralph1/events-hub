import { useState, useEffect } from 'react'
 
export function useFeedbacks() {
    const [feedbacks, setFeedbacks] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getFeedbacks({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getFeedbacks({ signal } = {}) {
        return axios.get('super-admin/feedbacks', { signal })
        .then(response => setFeedbacks(response.data.data))
        .catch(() => {})
    }
    
    return { feedbacks, getFeedbacks }
}
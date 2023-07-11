import { useNavigate } from 'react-router-dom'
import { useFeedback } from '@/hooks/useFeedback'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
 
function CreateFeedback() {
    const { feedback, createFeedback } = useFeedback()
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await createFeedback(feedback.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
        <div className="">
    
            <h1 className="">Add Feedback</h1>
    
            <div className="">
            <label htmlFor="subject" className="">Subject</label>
            <input
                id="subject"
                name="subject"
                type="text"
                value={ feedback.data.subject ?? '' }
                onChange={ event => feedback.setData({
                ...feedback.data,
                subject: event.target.value,
                }) }
                className=""
                disabled={ feedback.loading }
            />
            <ValidationError errors={ feedback.errors } field="subject" />
            </div>
    
            <div className="">
            <label htmlFor="message" className="">Message</label>
            <input
                id="message"
                name="message"
                type="text"
                value={ feedback.data.message ?? '' }
                onChange={ event => feedback.setData({
                ...feedback.data,
                message: event.target.value,
                }) }
                className=""
                disabled={ feedback.loading }
            />
            <ValidationError errors={ feedback.errors } field="message" />
            </div>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="">
            <button
                type="submit"
                className=""
                disabled={ feedback.loading }
            >
                { feedback.loading && <IconSpinner /> }
                Save Feedback
            </button>
    
            <button
                type="button"
                className=""
                disabled={ feedback.loading }
                onClick={ () => navigate(route('feedbacks.index')) }
            >
                <span>Cancel</span>
            </button>
            </div>
        </div>
        </form>
    )
}
 
export default CreateFeedback
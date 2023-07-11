import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useFeedbacks } from '@/hooks/useFeedbacks'
import { useFeedback } from '@/hooks/useFeedback'
 
function FeedbacksList() {
    const { feedbacks, getFeedbacks } = useFeedbacks()
    const { destroyFeedback } = useFeedback()
    
    return (
        <div className="">
    
            <h1 className="">Feedbacks</h1>
        
            <Link to={ route('feedbacks.create') } className="">
                Add Feedback
            </Link>
        
            <div className="border-t h-[1px] my-6"></div>
        
            <div className="">
                { feedbacks.length > 0 && feedbacks.map(feedback => {
                return (
                    <div
                    key={ feedback.id }
                    className=""
                    >
                        <div className="">
                            <div className="">
                                { feedback.subject }
                            </div>
                            <div className="">
                                { feedback.message }
                            </div>
                        </div>
                        <div className="flex gap-1">
                            <Link
                                to={ route('feedbacks.edit', { id: feedback.id }) }
                                className=""
                            >
                            Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyFeedback(feedback)
                                    await getFeedbacks()
                                } }
                            >
                            X
                            </button>
                        </div>
                    </div>
                )
                })}
            </div>
        </div>
    )
}
 
export default FeedbacksList
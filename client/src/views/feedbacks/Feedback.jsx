import { Link, useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useFeedback } from '@/hooks/useFeedback'
 
function Feedback() {
    const params = useParams()
    const { feedback } = useFeedback(params.id)
    const navigate = useNavigate()
    
    return (
        <div className="">
    
            <h1 className="">Feedback <b>{ feedback.subject }</b></h1>

            <p>Name: { feedback.subject }</p>
    
            <p>Description: { feedback.message }</p>
    
            <div className="border-t h-[1px] my-6"></div>
    
             <div className="">
                <Link to={ route('feedbacks.index') } className="">
                    All Feedbacks
                </Link>
            </div>
        </div>
    )
}
 
export default Feedback
import { useState } from 'react'
import { useAuth } from '@/hooks/useAuth'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'

const Login = () => {
    const [username, setUsername] = useState('')
    const [password, setPassword] = useState('')
    const [remember, setRemember] = useState(false)
    const { login, errors, loading } = useAuth()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await login({ username, password })
    
        setPassword('')
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
        <div className="">
            <h1 className="">Login</h1>
            <div className="">
            <label htmlFor="username" className="">Username</label>
            <input
                id="username"
                name="username"
                type="text"
                value={ username }
                onChange={ event => setUsername(event.target.value) }
                className=""
                autoComplete="username"
                disabled={ loading }
            />
            <ValidationError errors={ errors } field="username" />
            </div>
    
            <div className="">
            <label htmlFor="password" className="">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                value={ password }
                onChange={ event => setPassword(event.target.value) }
                className=""
                autoComplete="current-password"
                disabled={ loading }
            />
            <ValidationError errors={ errors } field="password" />
            </div>
    
            <div className="">
            <label className="" htmlFor="remember">
                <input
                id="remember"
                name="remember"
                type="checkbox"
                className="w-4 h-4"
                checked={ remember }
                onChange={ () => setRemember((previous) => !previous) }
                disabled={ loading }
                />
                <span className="">Remember me</span>
            </label>
            </div>
    
            <div className=""></div>
    
            <div className="">
            <button type="submit" className="" disabled={ loading }>
                { loading && <IconSpinner /> }
                Login
            </button>
            </div>
        </div>
        </form>
    )
}

export default Login
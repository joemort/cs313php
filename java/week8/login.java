package week8;

import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;

@WebServlet(name = "login", urlPatterns = {"/login"})
public class login extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        String name = "test";
        String pass = "test";

        String username = request.getParameter("user");
        String password = request.getParameter("pass");

        if (name.equals(username) && pass.equals(password)) {
            request.getSession().setAttribute("username", username);
            request.getSession().removeAttribute("failure");
            response.sendRedirect("welcome.jsp");
        } else {
            request.getSession().setAttribute("failure", "Use the correct username/password: test/test");
            response.sendRedirect("index.jsp");
        }
    }
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }
    
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package week8;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.util.List;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet(name = "Login", urlPatterns = {"/LoginDiscussion"})
public class Login extends HttpServlet {

    private List<String> usernames;
    private List<String> passwords;

    public void addLoginInfo(String username, String password) {

        usernames.add(username);
        passwords.add(password);

        try {
            String dataDirectory = System.getenv("OPENSHIFT_DATA_DIR");
            String fileName = "loginData.txt";
            if (dataDirectory != null) {
                fileName = dataDirectory + "/" + fileName;
            }

            File file = new File(fileName);
            file.createNewFile();
            BufferedWriter writer = new BufferedWriter(new FileWriter(file, true));
            writer.write(username + "\n" + password + "\n");
            writer.close();

        } catch (IOException e) {
            e.printStackTrace();
        }

    }

    public void getLoginInfo() {
        usernames = new ArrayList<String>();
        passwords = new ArrayList<String>();

        try {
            String dataDirectory = System.getenv("OPENSHIFT_DATA_DIR");
            String fileName = "loginData.txt";
            if (dataDirectory != null) {
                fileName = dataDirectory + "/" + fileName;
            }

            File file = new File(fileName);
            file.createNewFile();
            BufferedReader reader = new BufferedReader(new FileReader(file));

            String line;
            Boolean change = true;

            while ((line = reader.readLine()) != null) {
                if (change) {
                    usernames.add(line);
                    change = false;
                } else {
                    passwords.add(line);
                    change = true;
                }
            }

        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public Boolean isValidLogin(String username, String password) {
        int index = -1;

        if (usernames.contains(username)) {
            index = usernames.indexOf(username);
        } //if not in list add to list
        else {
            addLoginInfo(username, password);
            return true;
        }

        if (passwords.get(index).equals(password)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) {

            String username = request.getParameter("user");
            String password = request.getParameter("pass");

            getLoginInfo();

            if (isValidLogin(username, password)) {
                request.getSession().setAttribute("username", username);
                response.sendRedirect("addToDiscussionBoard.jsp");
            } else {
                request.getRequestDispatcher("LoginFail.jsp").forward(request, response);
            }
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}

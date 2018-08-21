module.exports = {

    devServer: {
        proxy: {
            '/AjaxSecond': {
                target: 'http://quiz.test/',
                ws: true,
                changeOrigin: true
            }
        }
    },


    pages: {
        index: {
            entry: 'resources/app.js'
        }

    }

}